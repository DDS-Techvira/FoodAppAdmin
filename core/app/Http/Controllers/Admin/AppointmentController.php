<?php

namespace App\Http\Controllers\Admin;

use App\ScheduledAppointments;
use App\Doctor;
use App\Users;
use App\Appointment;
use App\CoachAvailabilityModel;
use App\CoachAvailableDetail;
use App\PrincipalAvailableTimeModel;
use App\GeneralSetting;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\CommonPHP\PushNotificationCommon;
use Illuminate\Http\Request;
use Auth;

class AppointmentController extends Controller
{
    public function createAppointment(){
        $page_title = 'Create Schedule Appointment';
        $doctors = Users::where('status',1)->where('user_type','coach')->latest()->get();

        return view('admin.appointment.create-appointment',compact('page_title','doctors'));
    }

    public function bookedDate(Request $request){
        $data = Appointment::where('doctor_id',$request->doctor_id)->where('try',1)->where('d_status',0)->whereDate('booking_date',Carbon::parse($request->date))->get()->map(function($item){
            return str_slug($item->time_serial);
        });
        return response()->json(@$data);
    }

    public function appointmentDetails(Request $request){

        $request->validate([
            'coach_id' => 'required',
        ]);

        $doctor = Users::where('user_code','=',$request->coach_id)->first();

        // if ($doctor->serial_or_slot == null || empty($doctor->serial_or_slot)) {
        //     $notify[] = ['error', 'No available schedule for this doctor'];
        //     return back()->withNotify($notify);
        // }

        $available_date = [];
        if($request->date==null){
            $date = Carbon::now();
        }

        $date_count = Carbon::now();

        
        $user = CoachAvailabilityModel::select('coach_availability_detail.time_slots_15','coach_availability_detail.time_slots_30','coach_availability_detail.time_slots_60','coach_availability.start_time','coach_availability.end_time','coach_availability.from_date','coach_availability.to_date')
    ->where('coach_code','=',$request->coach_id)
    ->where('coach_availability_detail.date','=', $date->addDays(1)->format('Y-m-d'))
    ->join('coach_availability_detail','coach_availability_detail.avail_code','coach_availability.avail_code')
    // ->whereBetween($request->date, ['coach_availability.from_date', 'coach_availability.to_date'])
    ->first();


   
    $start_date=Carbon::parse($user->from_date);
    $end_date=Carbon::parse($user->to_date);
    $start_time=date('h:i A',strtotime($user->start_time));
    $end_time=date('h:i A',strtotime($user->end_time));
    $total_dates = $end_date->diffInDays($start_date);
    // return $date->addDays(1)->format('Y-m-d');
    for ($i=0; $i <$total_dates; $i++) {
        array_push($available_date, date('Y-m-d',strtotime($date_count)));
        $date_count->addDays(1);
    }
    // return $user[0]['time_slots'];
    $available_slots = array();
    $final_available_slots = array();
    $time_slots = array();
    $time_slots = array();
    // // $time_slots[]=$user['time_slots_15'];
    // $arrays[] =  (array) $user['time_slots_15'];
    // $slotsDecode_15=json_decode($user['time_slots_15']);
    $slotsDecode_30=json_decode($user['time_slots_30']);
    $slotsDecode_60=json_decode($user['time_slots_60']);
//    return json_decode($user['time_slots']);

    // if($user->count()>0){
    //    if($request->duration==30){
    //         return response()->json($slotsDecode_30);
    //     }
    //     elseif($request->duration==60){
            
    //        return response()->json($slotsDecode_60);
    //     }
    // }
    // else{
    //     return response()->json(null);
    // }

        $page_title = 'Appointment Booking';

        return view('admin.appointment.book-appointment',compact('doctor','page_title','available_date','slotsDecode_30','slotsDecode_60','start_time','end_time'));
    }


    public function appointmentStore(Request $request,$id)
    {

        $this->validate($request, [
            'booking_date' => 'required|date',
            'time_serial' => 'required',
            'name' => 'required|max:50',
            'email' => 'required|email',
            'mobile' => 'required|max:50',
            'age' => 'required|numeric|gt:0',
        ],[
            'time_serial.required'=>'You did not select any time or serial',
        ]);

        $doctor = Doctor::findOrFail($id);
        $time_serial_check = $doctor->whereJsonContains('serial_or_slot',$request->time_serial)->first();

        if($time_serial_check){
            $existed_appointment = Appointment::where('doctor_id',$doctor->id)->where('booking_date',$request->booking_date)->where('time_serial',$request->time_serial)->where('try',1)->where('d_status',0)->first();

            if($existed_appointment){
                $notify[] = ['error', 'This appointment is already booked. Try another date or serial'];
                return back()->withNotify($notify);
            }

            $general = GeneralSetting::first();

            $appointment = Appointment::create([
                'booking_date' => Carbon::parse($request->booking_date)->format('Y-m-d'),
                'time_serial' => $request->time_serial,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'age' => $request->age,
                'doctor_id' => $doctor->id,
                'admin' => 1,
                'disease' => $request->disease,
                'try' => 1,
            ]);

            $patient = 1;
            notify($appointment, 'APPOINTMENT_CONFIRM', [
                'booking_date' => $appointment->booking_date,
                'time_serial' => $appointment->time_serial,
                'doctor_name' => $doctor->name,
                'doctor_fees' => ''.$doctor->fees.' '.$general->cur_text.'',
            ],$patient);

            $notify[] = ['success', 'Your appointment has been taken.'];
            return back()->withNotify($notify);

        }else{
            $notify[] = ['error', 'Do not try to cheat us'];
            return back()->withNotify($notify);
        }

    }

    public function allAppointment(){
        $page_title = 'New Appointments';
    //     $appointments = Appointment::where('try',1)->where('is_complete',0)->where('d_status',0)->whereHas('doctor', function ($query) {
    //         $query->where('status',1);
    //    })->latest()->paginate(getPaginate());
       $appointments = ScheduledAppointments::Join('users as coach','coach.user_code','scheduled_appointments.coach_code') 
       ->join('users as principal','principal.user_code','scheduled_appointments.principal_code') 
       ->select('scheduled_appointments.*','coach.first_name as coach_first_name','coach.last_name as coach_last_name','principal.first_name as principal_first_name','principal.last_name as principal_last_name','principal.profile_image')
        ->Where('scheduled_appointments.status','!=',6)
       ->latest()->paginate(getPaginate());
        $empty_message = 'No Appointment Found';
        return view('admin.appointment.appointment',compact('page_title','appointments','empty_message'));
    }

    public function appointmentView(Request $request, $id)
    {

        $appointment =  Appointment::findOrFail($id);

        if ($request->complete) {
            $appointment->is_complete = 1;

            if($appointment->p_status == 0){
                $doctor = Doctor::findOrFail($appointment->doctor->id);
                $doctor->balance += $doctor->fees;
                $doctor->save();

                $appointment->p_status = 1;
            }

            $appointment->save();

            $notify[] = ['success', 'Service Done Successfully'];
            return back()->withNotify($notify);
        }
    }

    public function appointmentDone(){
        $page_title = 'Done Appointments';
        $appointments = Appointment::where('try',1)->where('is_complete',1)->where('d_status',0)->whereHas('doctor', function ($query) {
            $query->where('status',1);
       })->latest()->paginate(getPaginate());
        $empty_message = 'No Done Appointment Found';
        return view('admin.appointment.appointment',compact('page_title','appointments','empty_message'));
    }

    public function appointmentRemove($id){
        $appointment = Appointment::findOrFail($id);
        $appointment->d_status = 1;
        $appointment->d_admin = 1;
        $appointment->save();

        $patient = 1;
        notify($appointment, 'APPOINTMENT_REJECT', [
            'booking_date' => $appointment->booking_date,
            'time_serial' => $appointment->time_serial,
            'doctor_name' => $appointment->doctor->name,
        ],$patient);

        $notify[] = ['success', 'Your appointment goes in trashed appointments'];
        return back()->withNotify($notify);
    }
    public function appointmentRemoveFromAdmin($id){
        $appointment = ScheduledAppointments::findOrFail($id);
        $appointment->status = 6;
        $appointment->save();

        // $patient = 1;
        // notify($appointment, 'APPOINTMENT_REJECT', [
        //     'booking_date' => $appointment->booking_date,
        //     'time_serial' => $appointment->time_serial,
        //     'doctor_name' => $appointment->doctor->name,
        // ],$patient);

        $notify[] = ['success', 'Your appointment goes in trashed appointments'];
        return back()->withNotify($notify);
    }

    public function appointmentTrashed(){
        $page_title = 'Trashed Appointment';

        $appointments = Appointment::where('d_status',1)->whereHas('doctor', function ($query) {
            $query->where('status',1);
       })->latest()->paginate(getPaginate());
        $empty_message = 'No Trashed Appointment Found';

        return view('admin.appointment.trashed-appointment',compact('page_title','appointments','empty_message'));
    }
    public function DeleteAppointment($appt_code)
{   

    $appt = ScheduledAppointments::where('scheduled_appointments.appointments_code',$appt_code)->first();
    $appt->status = 3;
    $appt->cancel_note = 'Cancel By Admin';
    $appt->save();
    
    $coachAvailability = CoachAvailableDetail::where('coach_availability.coach_code',$appt->coach_code)
    ->where('coach_availability_detail.date',$appt->appt_date)
    ->join('coach_availability','coach_availability.avail_code','coach_availability_detail.avail_code')
    ->first();

    $coach = Users::where('user_code',$appt->coach_code)->first();

    $principal = Users::where('user_code',$appt->principal_code)->first();

    $date_now = time(); //current timestamp
    $date_convert = strtotime($appt->appt_date);
    if($coachAvailability && $appt->duration==60){
        $slotsDecode_60=$coachAvailability['time_slots_60'] ?? [];
        // if (($key = array_search($request->time_slot, $slotsDecode_60)) !== false) {
        //          unset($slotsDecode_60[$key]);
        //     }
            array_push($slotsDecode_60, $appt->time_slot);
            $final_available_slots = array_values($slotsDecode_60);
            usort($final_available_slots, function($a, $b) {
                return (strtotime($a) > strtotime($b));
            });
            $coachAvailability_save = CoachAvailableDetail::where('coach_availability_detail.avail_code',$coachAvailability->avail_code)
            ->where('coach_availability_detail.date',$appt->appt_date)
            ->first();
            $coachAvailability_save->time_slots_60 = $final_available_slots;
            $coachAvailability_save->save();
    }

    if($coachAvailability && $appt->duration==30){
        $slotsDecode_30=$coachAvailability['time_slots_30'] ?? [];
        // if (($key = array_search($request->time_slot, $slotsDecode_30)) !== false) {
        //          unset($slotsDecode_30[$key]);
        //     }
        array_push($slotsDecode_30, $appt->time_slot);
        $final_available_slots = array_values($slotsDecode_30);
        usort($final_available_slots, function($a, $b) {
            return (strtotime($a) > strtotime($b));
        });
        $coachAvailability_save = CoachAvailableDetail::where('coach_availability_detail.avail_code',$coachAvailability->avail_code)
        ->where('coach_availability_detail.date',$appt->appt_date)
        ->first();
        $coachAvailability_save->time_slots_30 = $final_available_slots;
        $coachAvailability_save->save();
    }

    if( $date_convert> $date_now){
        $addtimeavailbale = PrincipalAvailableTimeModel::where('principal_available_time.user_code',$appt->principal_code)->first();
        $addtimeavailbale->available_time = $addtimeavailbale->available_time +$appt->duration;
        $addtimeavailbale->spend_time =$addtimeavailbale->spend_time-$appt->duration;
        $addtimeavailbale->save();
        $appt->save();
    }

    $noty_msg_body = 'An Admin has cancelled your '. date('m-d-Y h:i A', strtotime($appt->appt_date.' '.$appt->time_slot)) .' appointment with ' . $coach->first_name . ' ' . $coach->last_name;
    $noty_msg_title = 'Cancelled Appointment By Admin';
    // $noty_msg_body = 'Appointment has been cancelled by Admin of Coach ' . $principal->first_name . ' ' . $principal->last_name.' In'. $appt->appt_date .'at'.$appt->time_slot.' Appointment';
    $click_action = 'https://admin.theprincipalsclub.com';
    $msg_type = 'appointment_cancel';
    $msg_id = $appt->id;
    $sub_id = 0;
    //dr reply to special msg

    PushNotificationCommon::sendNotification($principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

    $noty_msg_body = 'An Admin has cancelled your '. date('m-d-Y h:i A', strtotime($appt->appt_date.' '.$appt->time_slot)) .' appointment with ' . $principal->first_name . ' ' . $principal->last_name;
    PushNotificationCommon::sendNotification($coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

    // return response()->json('Deleted');
    $notify[] = ['success', 'Your appointment cancelled Successfully'];
    return back()->withNotify($notify);
}



}
