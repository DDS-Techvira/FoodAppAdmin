<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Books;
use App\BuyBook;
use App\Doctor;
use App\DrArticles;
use App\DrYotube;
use App\GeneralSetting;
use App\Patient;
use App\Prescription;
use App\PrescriptionImage;
use App\Sector;
use App\PostsModel;
use App\Users;
use App\FeedbackChatMessageModel;
use App\TechnicalChatReportModel;
use App\OtherChatReportModel;
use App\OtherChatMessageModel;
use App\CoachAvailableDetail;
use App\NotificationModel;
use App\ChatMessagesModel;
use App\ChatsReportModel;
use App\CoachAvailabilityModel;
use App\ScheduledAppointments;
use App\PushNotificationsTokenModel;
use App\PrincipalAvailableTimeModel;
use App\CallHostoryModel;
use App\WebinarModel;
use App\CoachFeedback;
use App\WebinarUsersModel;
use App\TechnicalChatMessageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\CommonPHP\Agora\RtcTokenBuilder;
use DateTime;
use App\CommonPHP\PushNotificationCommon;
use Uuid;
use DateTimeZone;
use App\CoachWriteUp;
class MobileAppController extends Controller
{
    public function loginAccount(Request $request)
    {
       $user_type= $request->user_type;

       if( $user_type=='customer'){
        $user = Users::Where('user_type', '=','customer')->Where('status', '=',1)->where('email', '=', $request->email)->first();

        if ($user) {
           if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'user' => $user,
                'message' =>'success'
            ]);

           }
           else{
            return response()->json([
                'message' =>'password_invalid'
            ]);
           }
       }
       else{
        $userbanned = Users::Where('user_type', '=','customer')->Where('status', '=',0)->where('email', '=', $request->email)->first();
           if($userbanned){
            return response()->json([
                'message' =>'user_inactive'
            ]);
           }
           else{
            return response()->json([
                'message' =>'user_not_found'
            ]);
           }
     

       }


    }
    elseif( $user_type=='coach'){
        $user = Users::Where('user_type', '=','coach')->Where('status', '=',1)->where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'user' => $user,
                    'message' =>'success'
                ]);

               }
               else{
                return response()->json([
                    'message' =>'password_invalid'
                ]);
               }
       }
       else{
        return response()->json([
            'message' =>'user_not_found'
        ]);

       }
    }
}
public function getCategories(Request $request)
{
    $user = Sector::where('sectors.status','=',1)->get();
   return response()->json($user);

   
}


public function storeUserDetails(Request $request){

    $coach_image = 'gxaK9RVMHHMyrW9Ctpevd9EFMGfYZ6rfXojwS27n.jpg';
   

    $user = new Users();
    $user->user_code = Uuid::generate(4);
    $user->profile_image = $coach_image;
    $user->user_type =  $request->user_type;
    $user->first_name =  $request->first_name;
    $user->last_name = $request->last_name;
    $user->email =  $request->email;
    $user->mobile_no =  $request->mobile;
    $user->bio =$request->about;
    $user->password =  Hash::make($request->password);
    $user->save();

    return response()->json([
        'message' =>'success'
    ]);
}
// public function getDoctors(Request $request)
// {
//     $user = Doctor::select('doctors.*','sectors.name AS category')
//     ->join('sectors','doctors.sector_id','sectors.id')
//     ->get();
//    return response()->json($user);

// }
// public function getDoctorsByCat(Request $request)
// {
//     $user = Doctor::select('doctors.*','sectors.name AS category')
//     ->join('sectors','doctors.sector_id','sectors.id')
//     ->where('sectors.name','=',$request->category)
//     ->get();
//    return response()->json($user);

// }
// public function getPrescriptionByPatient(Request $request)
// {
//     $user = Prescription::select('prescription.*','doctors.name AS doctor_name','doctors.image')
//     ->join('doctors','doctors.id','prescription.doctor_id')
//     ->join('appointments','appointments.id','prescription.appointment_id')
//     ->where('prescription.patient_id','=',$request->patient_id)
//     ->get();
//    return response()->json($user);

// }
// public function getPrescriptionImageById(Request $request)
// {
//     $user = PrescriptionImage::where('prescription_id','=',$request->id)
//     ->get();
//    return response()->json($user);

// }

// public function getAppointmentTimeSlots(Request $request)
// {
//     $user = Doctor::select('doctors.serial_or_slot')
//     ->where('doctors.id','=',$request->id)
//     ->get();
//     $available_slots = array();
//     for ($i = 0; $i < sizeof($user[0]['serial_or_slot']); $i++) {// for loop for all selected test
//         $appointment = Appointment::Where('booking_date','=',$request->date)
//         ->where('time_serial','=',$user[0]['serial_or_slot'][$i])
//         ->first();


//         if($appointment){

//         }
//         else{
//             $available_slots[]=$user[0]['serial_or_slot'][$i];
//         }
//         // $available_slots[]=$user[0]['serial_or_slot'][$i];
//         }
//    return response()->json($available_slots);

// }
// public function appointmentStore(Request $request)
// {

//     // $this->validate($request, [
//     //     'booking_date' => 'required|date',
//     //     'time_serial' => 'required',
//     //     'name' => 'required|max:50',
//     //     'email' => 'required|email',
//     //     'mobile' => 'required|max:50',
//     //     'age' => 'required|numeric|gt:0',
//     // ],[
//     //     'time_serial.required'=>'You did not select any time or serial',
//     // ]);

//     // $doctor = Doctor::findOrFail($id);
//     // $time_serial_check = $doctor->whereJsonContains('serial_or_slot',$request->time_serial)->first();

//     // if($time_serial_check){
//         // $existed_appointment = Appointment::where('doctor_id',$doctor->id)->where('booking_date',$request->booking_date)->where('time_serial',$request->time_serial)->where('try',1)->where('d_status',0)->first();

//         // if($existed_appointment){
//         //     $notify[] = ['error', 'This appointment is already booked. Try another date or serial'];
//         //     return back()->withNotify($notify);
//         // }

//         // $general = GeneralSetting::first();

//         $appointment = Appointment::create([
//             'booking_date' => Carbon::parse($request->booking_date)->format('Y-m-d'),
//             'time_serial' => $request->time_serial,
//             'name' => $request->name,
//             'email' => $request->email,
//             'mobile' => $request->mobile,
//             'age' => $request->age,
//             'doctor_id' => $request->doctor_id,
//             'patient' => $request->patient_id,
//             // 'admin' => 1,
//             'p_status '=>2,
//             'disease' => $request->disease,
//             'try' => 1,
//         ]);

//         $patient = 1;
//         // notify($appointment, 'APPOINTMENT_CONFIRM', [
//         //     'booking_date' => $appointment->booking_date,
//         //     'time_serial' => $appointment->time_serial,
//         //     'doctor_name' => $doctor->name,
//         //     'doctor_fees' => ''.$doctor->fees.' '.$general->cur_text.'',
//         // ],$patient);

//         // $notify[] = ['success', 'Your appointment has been taken.'];
//         return response()->json($appointment);

//     // }else{
//     //     $notify[] = ['error', 'Do not try to cheat us'];
//     //     return back()->withNotify($notify);
//     // }

// }
// public function getAppointmenDetailsByPatientId(Request $request)
// {
//     $appointments = Appointment::where('patient',$request->patient_id)->where('is_complete',0)->where('d_status',0)
//     ->join('doctors','doctors.id','appointments.doctor_id')
//     ->select('appointments.*','doctors.name AS doc_name','doctors.image','doctors.mobile AS doc_mobile')
//     ->orderBy('appointments.created_at', 'DESC')
//     ->get();
//    return response()->json($appointments);

// }
// public function getArticlesByDocId(Request $request)
// {
//     $education_details = DrArticles::select('doctor_articles.*','doctors.name','sectors.name AS sectorName')
//     ->where('doctor_id', $request->doc_id)
//     ->join('doctors', 'doctors.id', '=', 'doctor_articles.doctor_id')
//     ->join('sectors', 'sectors.id', '=', 'doctor_articles.category')
//     ->get();
//    return response()->json($education_details);

// }
// public function getYotubeByDocId(Request $request)
// {
//     $education_details = DrYotube::select('doctor_videos.*','doctors.name','sectors.name AS sectorName')
//     ->where('doctor_id', $request->doc_id)
//     ->join('doctors', 'doctors.id', '=', 'doctor_videos.doctor_id')
//     ->join('sectors', 'sectors.id', '=', 'doctor_videos.category')
//     ->get();
//    return response()->json($education_details);

// }
// public function getAllBooks(Request $request)
// {
//     $education_details = Books::all();
//    return response()->json($education_details);

// }
// public function prescriptionStore(Request $request)
// {

//     // $this->validate($request, [
//     //     'disease' => 'required',
//     //     'note' => 'required',
//     // ]);
//     $prescription = new Prescription();
//     $prescription->appointment_id = $request->appointment_id;
//     $prescription->disease =  $request->disease;
//     $prescription->patient_id =  $request->patient_id;
//     $prescription->doctor_id = $request->doctor_id;
//     $prescription->note =  $request->note;
//     $prescription->date = Carbon::now();
//     $prescription->save();

//     $selectedPrescriptionDocument = $request->input('selectedDocument');//array of selected document

//     if ($selectedPrescriptionDocument != []) {
//         for ($i = 0; $i < sizeof($selectedPrescriptionDocument); $i++) {// for loop for all selected test
//             $prescription_document = new PrescriptionImage();
//             $prescription_document->prescription_id = $prescription->id;
//             $prescription_document->attachment_name  = $selectedPrescriptionDocument[$i];
//             $prescription_document->date = Carbon::now();
//             $prescription_document->save();

//             }
//     }
//     $appointments = Appointment::where('id', '=', $request->appointment_id)->update([
//         'is_complete' => 1]);

//         $patient = 1;
//         // notify($appointment, 'APPOINTMENT_CONFIRM', [
//         //     'booking_date' => $appointment->booking_date,
//         //     'time_serial' => $appointment->time_serial,
//         //     'doctor_name' => $doctor->name,
//         //     'doctor_fees' => ''.$doctor->fees.' '.$general->cur_text.'',
//         // ],$patient);

//         $notify[] = ['success', 'Your prescription has been taken.'];
//         return back()->withNotify($notify);



// }
// public function getAppointmenDetailsByDoctorId(Request $request)
// {
//     $appointments = Appointment::where('doctor_id',$request->doctor_id)->where('try',1)->where('is_complete',0)->where('d_status',0)
//     ->join('patients','patients.id','appointments.patient')
//     ->select('appointments.*','patients.name AS doc_name','patients.image','patients.mobile AS doc_mobile')
//     ->get();
//    return response()->json($appointments);

// }
// public function patientPrescriptionReportUpload(Request $request)
// {
//     $image = $request->file('file');
//     $imageName = $image->getClientOriginalName();
//     $done=$image->move('assets/appointment/prescription', $imageName);
//     return response()->json(['successss' => $imageName]);

//     // try{

//     //     $location = imagePath()['appointment']['path'];
//     //     $size = imagePath()['appointment']['size'];
//     //     $image->move($path, $filename);
//     //   $staff_image = uploadImage($request->file('file'), $location , $size);

//     // }catch(\Exception $exp) {
//     //     return 'error Could not upload the image.';
//     // }
// }
// public function UploadPrescriptionImage(Request $request)
// {
//     $image = $request->image;
//     $name = $request->name;
//     $realImage = base64_decode($image);
//     $fileinfo = pathinfo($name);
//     $extention = $fileinfo['extension'];
//     $new_name = rand() . '.' . $extention;


//     file_put_contents('assets/appointment/prescription' . '/' . $new_name, $realImage);
//     return response()->json($new_name);

// }
// public function scheduleManage(Request $request){

//     // $this->validate($request, [
//     //     'slot_type' => 'required|numeric|gt:0',
//     //     'max_serial' => 'sometimes|required|numeric|min:1',
//     //     'duration' => 'sometimes|required|numeric|gt:0',
//     //     'serial_day' => 'required|numeric|gt:0',
//     //     'start_time' => 'sometimes|required',
//     //     'end_time' => 'sometimes|required'
//     // ]);

//     $doctor = Doctor::findOrFail($request->doctor_id);

//     if ($request->slot_type == 1 && $request->max_serial > 0) {

//         $serial_or_slot = [];

//         for ($i=1; $i <= $request->max_serial; $i++) {
//             array_push($serial_or_slot,"$i");
//         }

//         $doctor->serial_or_slot = $serial_or_slot;
//         $doctor->max_serial = $request->max_serial;

//     }
//     elseif ($request->slot_type == 2 && $request->duration > 0) {

//         $start_time = Carbon::parse($request->start_time);
//         $end_time = Carbon::parse($request->end_time);
//         $total_min = $end_time->diffInMinutes($start_time);
//         $total_slot = $total_min / $request->duration;

//         $serial_or_slot = [];

//         for ($i=1; $i <= $total_slot; $i++) {

//             array_push($serial_or_slot,date('h:i:a',strtotime($start_time)));
//             $start_time->addMinutes($request->duration);
//         }

//         $doctor->serial_or_slot = $serial_or_slot;
//         $doctor->duration = $request->duration;
//         $doctor->start_time = Carbon::parse($request->start_time)->format('h:i a');
//         $doctor->end_time = Carbon::parse($request->end_time)->format('h:i a');
//     }
//     else{
//         return response()->json('error');
//     }

//     $doctor->slot_type = $request->slot_type;
//     $doctor->serial_day = $request->serial_day;
//     $doctor->save();

//     $notify[] = ['success', 'Time schedule has been updated'];
//     // return back()->withNotify($notify);
//     return response()->json('success');
// }
// public function UploadPatientImage(Request $request)
// {
//     $image = $request->image;
//     $name = $request->name;
//     $realImage = base64_decode($image);
//     $fileinfo = pathinfo($name);
//     $extention = $fileinfo['extension'];
//     $new_name = rand() . '.' . $extention;


//     file_put_contents('assets/staff/images/profile' . '/' . $new_name, $realImage);
//     return response()->json($new_name);

// }
// public function UploadDoctorImage(Request $request)
// {
//     $image = $request->image;
//     $name = $request->name;
//     $realImage = base64_decode($image);
//     $fileinfo = pathinfo($name);
//     $extention = $fileinfo['extension'];
//     $new_name = rand() . '.' . $extention;


//     file_put_contents('assets/doctor/images/profile' . '/' . $new_name, $realImage);
//     return response()->json($new_name);

// }
// public function storePatient(Request $request){

// if($request->image==null){
//     $image="Noimage.png";
// }
// else{
//     $image=$request->image;
// }

//     $patient = Patient::create([
//         'image' => $image,
//         'name' => $request->name,
//         'email' => $request->email,
//         'mobile' => $request->mobile,
//         'password' => Hash::make($request->password),
//         'username' => $request->email,
//         'address' => $request->address,
//     ]);

//     return response()->json('Success');
// }
// public function storeDoctor(Request $request){

//     if($request->image==null){
//         $image="Noimage.png";
//     }
//     else{
//         $image=$request->image;
//     }
//     $doctor = Doctor::create([
//         'image' => $image,
//         'name' => $request->name,
//         'email' => $request->email,
//         'mobile' => $request->mobile,
//         'password' => Hash::make($request->password),
//         'username' => $request->username,
//         'sector_id' => $request->sector_id,
//         'qualification' => $request->qualification,
//         'address' => $request->address,
//         'location_id' => 1,
//         'fees' => $request->fees,
//         'rating' => 5,
//         'about' => $request->about,
//         'featured' => $request->featured ? 1 : 0,
//     ]);

//     return response()->json('Success');
// }
// public function getPatientDetails(Request $request)
// {
//     $user = Patient::where('id','=',$request->id)
//     ->first();
//    return response()->json($user);

// }
// public function getDoctorDetails(Request $request)
// {
//     $user = Doctor::where('id','=',$request->id)
//     ->first();
//    return response()->json($user);

// }
// public function updateDoctorDetails(Request $request)
// {
//     $patient = Doctor::find($request->id);
//     $patient->name = $request->get("name");
//     $patient->email = $request->get("email");
//     $patient->mobile = $request->get("mobile");
//     $patient->mobile = $request->get("mobile");
//     $patient->username = $request->get("username");
//     $patient->qualification = $request->get("qualification");
//     $patient->about = $request->get("about");
//     $patient->image = $request->get("image");
//     $patient->save();
//    return response()->json($patient);

// }
// public function updatePatientPassword(Request $request)
// {
//     $patient = Patient::where('email',$request->email)->first();
//     $patient->password = Hash::make($request->password);
//     $patient->save();
//    return response()->json($patient);

// }

// public function updateDoctorPassword(Request $request)
// {
//     $patient = Doctor::where('email',$request->email)->first();
//     $patient->password = Hash::make($request->password);
//     $patient->save();
//    return response()->json($request->password);

// }

// public function drsendPasswordResetOTP(Request $request)
// {   $patient = Doctor::Where('email',$request->email)->first();
//     if($patient)
//     {
//         send_general_email($request->email, 'Password Reset', 'As you have requested to reset the password please enter the below reset OTP on your Mobile to reset Password. OTP : '.$request->otp, $patient->name);
//         return response()->json('success');
//     }
//     else{
//         return response()->json('email');
//     }


// }

// public function patientsendPasswordResetOTP(Request $request)
// {   $patient = Patient::Where('email',$request->email)->first();
//     if($patient)
//     {
//         send_general_email($request->email, 'Password Reset', 'As you have requested to reset the password please enter the below reset OTP on your Mobile to reset Password. OTP : '.$request->otp, $patient->name);
//         return response()->json('success');
//     }
//     else{
//         return response()->json('email');
//     }


// }

// public function updatePtientDetails(Request $request)
// {
//     $patient = Patient::find($request->id);
//     $patient->name = $request->get("name");
//     $patient->email = $request->get("email");
//     $patient->mobile = $request->get("mobile");
//     $patient->address = $request->get("address");
//     $patient->username = $request->get("username");
//     $patient->image = $request->get("image");
//     $patient->save();
//    return response()->json($patient);

// }

// public function storeBookPurchase(Request $request)
// {
//     $book=BuyBook::where('book_payments.buyer_id','=',$request->get("buyer_id"))->where('book_payments.book_id','=',$request->get("book_id"))->where('book_payments.payment_status','=',1)->get();
//     // return response()->json($book);
//     if($book==[]){
//         return response()->json('Already');
//     }
//     $patient = new BuyBook;
//     $patient->book_id = $request->get("book_id");
//     $patient->buyer_id = $request->get("buyer_id");
//     $patient->payment_status = 0;
//     $patient->save();
//    return response()->json( $patient);

// }
// public function purchaseHistory(Request $request)
// {
//     $book=BuyBook::select('books.*')->where('book_payments.buyer_id','=',$request->get("buyer_id"))->join('books','books.id','book_payments.book_id')->where('book_payments.payment_status','=',1)->get();
//     if($book!=[]){
//         return response()->json($book);
//     }
//     else{
//         return;
//     }



// }
// public function visa_master_payment_done(Request $request)
// {

//     $payment = base64_decode($_POST ["payment"]);
//     $signature = base64_decode($_POST ["signature"]);
//     $custom_fields = base64_decode($_POST ["custom_fields"]);
//     //    test
//     $publickey = "-----BEGIN PUBLIC KEY-----
// MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC/XgbitCulgQI5MNBJVSuyEE0q
// 9y460Zmu+d46Mkua2jsCSqKwKdEGCE1dH8lTehwAmeUg0aSVlErheZjNeHFnBvyz
// wRu7aJz+r2bIlhcqmP3HjWazhmjV6D2yc6X+xzX7lAY16SghNFRx5bTSb9rrHOYS
// yxUy7Yf/QqCCqRI+iwIDAQAB
// -----END PUBLIC KEY-----";

//     //live
// //        $publickey = "-----BEGIN PUBLIC KEY-----
// //MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDp0nLwTPBR96TPKdygsRmY5ooi
// //1cIv9D0uzD9FVtgM4p1UnaQKO/NkvFin8oBDtJMRAjDmhZ+migxskhzxihiwtnIh
// //NCejystmndqzwLHFHzk9s77snfbekaqVqbZSn+Vt9ShROkVhI0FbWAfhkL4lsyeu
// //FyWLa4t36UdkjPti8wIDAQAB
// //-----END PUBLIC KEY-----";
//     openssl_public_decrypt($signature, $value, $publickey);
//     $custom_fields_varible = explode('|', $custom_fields);
//     $signature_status = false;

//     if ($value == $payment) {
//         $signature_status = true;
//     }
//     $responseVariables = explode('|', $payment);

//     if ($signature_status == true) {
//         if($custom_fields_varible[1]=='app'){
//             if($custom_fields_varible[2]=='appointment'){
//                 $order = Appointment::find($custom_fields_varible[0]);
//                 $order->p_status  = 1;
//                 $order->try  = 1;
//                 $order->save();
//                    return view('payments.payment_done');
//             }
//             else if($custom_fields_varible[2]=='book'){
//                 $order = BuyBook::find($custom_fields_varible[0]);
//                 $order->payment_status  = 1;
//                 $order->save();
//                    return view('payments.payment_done');
//             }
//         }
//         else if($custom_fields_varible[1]=='web'){
//             if($custom_fields_varible[2]=='appointment'){
//                 $order = Appointment::find($custom_fields_varible[0]);
//                 $order->p_status  = 1;
//                 $order->try  = 1;
//                 $order->save();
//                    return view('payments.payment_done');
//             }
//             else if($custom_fields_varible[2]=='book'){
//                 $order = BuyBook::find($custom_fields_varible[0]);
//                 $order->payment_status  = 1;
//                 $order->save();
//                    return view('payments.payment_done');
//             }
//         }


//     } else {
//         //unsuccessful
//        // return view('payments.payment_done');
//     }


// //        if($request->status_code == '0'){
// //            //successful
// //            return redirect()->route('order_confirmed');
// //        }else{
// //            //unsuccessful
// //            return view('frontend.payment.webxpay.response');
// //        }

// }
public function DeleteAppointment(Request $request)
{   
      $final_available_slots_60 =array();

    $appt = ScheduledAppointments::where('scheduled_appointments.appointments_code',$request->appt_code)->first();
    $appt->status = 3;
    $appt->cancel_note = $request->cancel_note;
    $appt->save();
    



    $coachAvailability = CoachAvailableDetail::where('coach_availability.coach_code',$appt->coach_code)
    ->where('coach_availability_detail.date',$appt->appt_date)
    ->join('coach_availability','coach_availability.avail_code','coach_availability_detail.avail_code')
    ->first();

  


    $coach = Users::where('user_code',$appt->coach_code)->first();

    $principal = Users::where('user_code',$appt->principal_code)->first();

    if($request->user != 'coach'){
        $date_now = time(); //current timestamp
        $date_convert = strtotime($appt->appt_date);
        if($request->duration==60){
            $slotsDecode_60=$coachAvailability['time_slots_60'];
            $slotsDecode_30=$coachAvailability['time_slots_30'];
            // if (($key = array_search($request->time_slot, $slotsDecode_60)) !== false) {
            //          unset($slotsDecode_60[$key]);
            //     }

         

                array_push($slotsDecode_60, date('h:i A',strtotime($appt->time_slot)));
                $final_available_slots = array_values($slotsDecode_60);
                usort($final_available_slots, function($a, $b) {
                    return (strtotime($a) > strtotime($b));
                });

                $hour_subs=substr($appt->time_slot, 0, 2);
                $pm_subs=substr($appt->time_slot, 6, 7);
                $time_serial=$hour_subs.':00 '.$pm_subs;
                $time_serial2=$hour_subs.':30 '.$pm_subs;
                array_push($slotsDecode_30, date('h:i A',strtotime($time_serial)));
                array_push($slotsDecode_30, date('h:i A',strtotime($time_serial2)));
                $final_available_slots_30 = array_values($slotsDecode_30);
                usort($final_available_slots_30, function($a, $b) {
                    return (strtotime($a) > strtotime($b));
                });


                $coachAvailability_save = CoachAvailableDetail::where('coach_availability_detail.avail_code',$coachAvailability->avail_code)
                ->where('coach_availability_detail.date',$appt->appt_date)
                ->first();
                $coachAvailability_save->time_slots_60 = $final_available_slots;
                $coachAvailability_save->time_slots_30 = $final_available_slots_30;
                $coachAvailability_save->save();
            
        
        }
        if($request->duration==30){
            $slotsDecode_30=$coachAvailability['time_slots_30'];
            $slotsDecode_60=$coachAvailability['time_slots_60'];
            // if (($key = array_search($request->time_slot, $slotsDecode_30)) !== false) {
            //          unset($slotsDecode_30[$key]);
            //     }
            array_push($slotsDecode_30, date('h:i A',strtotime($appt->time_slot)));
            $final_available_slots = array_values($slotsDecode_30);
            usort($final_available_slots, function($a, $b) {
                return (strtotime($a) > strtotime($b));
            });
           
            $hour_subs=substr($appt->time_slot, 0, 2);
            $pm_subs=substr($appt->time_slot, 6, 7);
            $minute_subs=substr($appt->time_slot, 3, 5);
            $time_serial=$hour_subs.':00 '.$pm_subs;
            $time_serial_search;
            // if($minute_subs=='30'){
            //     $time_serial_search=$hour_subs.':00 '.$pm_subs;
            // }
            // else{
            //     $time_serial_search=$hour_subs.':30 '.$pm_subs;
            // }
            
           
            // $apptsearch = ScheduledAppointments::where('scheduled_appointments.time_slot',$time_serial_search)->where('scheduled_appointments.status',1)->first();
    
          
           
            // if($apptsearch==null || $apptsearch==""){
                array_push($slotsDecode_60, date('h:i A',strtotime($time_serial)));
                $final_available_slots_60 = array_values($slotsDecode_60);
            usort($final_available_slots_60, function($a, $b) {
                return (strtotime($a) > strtotime($b));
            });
        // }
            $coachAvailability_save = CoachAvailableDetail::where('coach_availability_detail.avail_code',$coachAvailability->avail_code)
            ->where('coach_availability_detail.date',$appt->appt_date)
            ->first();
            $coachAvailability_save->time_slots_30 = $final_available_slots;
            $coachAvailability_save->time_slots_60 = $final_available_slots_60;
            $coachAvailability_save->save();
        
        
        }
        $start_at = date("Y-m-d h:iA", strtotime("$appt->appt_date $appt->time_slot"));
        $end_at = date("Y-m-d h:iA", strtotime("-24 hours", strtotime($start_at)));
        
        $now = date("Y-m-d h:iA", strtotime("now"));

        \Log::info("now >>>>> $now");
        \Log::info("start_at >>>>> $start_at");
        \Log::info("end_at >>>>> $end_at");
        \Log::info("strtotime($end_at) > strtotime($now)");
        // return response()->json('Deleted');
        if( strtotime($end_at) > strtotime($now)){
            $addtimeavailbale = PrincipalAvailableTimeModel::where('principal_available_time.user_code',$appt->principal_code)->where('principal_available_time.year_month',$request->yearMonth)->first();
            $addtimeavailbale->available_time = $addtimeavailbale->available_time +$request->duration;
            $addtimeavailbale->spend_time =$addtimeavailbale->spend_time-$request->duration;
            $addtimeavailbale->save();
            $appt->save();
        }
    }
    else{
        $addtimeavailbale = PrincipalAvailableTimeModel::where('principal_available_time.user_code',$appt->principal_code)->where('principal_available_time.year_month',$request->yearMonth)->first();
        $addtimeavailbale->available_time = $addtimeavailbale->available_time +$request->duration;
        $addtimeavailbale->spend_time =$addtimeavailbale->spend_time-$request->duration;
        $addtimeavailbale->save();
        $appt->save();
    }

    if($request->user=='coach'){
            $noty_msg_body =  $coach->first_name . ' ' . $coach->last_name.' Coach has cancelled your '.Carbon::parse($appt->appt_date)->format('m-d-Y')  .' at '.$appt->time_slot.' appointment';
            $noty_msg_title = 'Cancelled Appointment by Coach';
            $click_action = 'https://admin.theprincipalsclub.com';
            $msg_type = 'appointment_cancel';
            $msg_id = $appt->id;
            $sub_id = $request->appt_code;

            
            //dr reply to special msg
        
            PushNotificationCommon::sendNotification($principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
           // PushNotificationCommon::sendNotification($coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
        
    }
    if($request->user=='principal'){
            $noty_msg_body =  $principal->first_name . ' ' . $principal->last_name.' has cancelled your '. Carbon::parse($appt->appt_date)->format('m-d-Y') .' at '.$appt->time_slot.' appointment';
            $noty_msg_title = 'Cancelled Appointment by Client';
            $click_action = 'https://admin.theprincipalsclub.com';
            $msg_type = 'appointment_cancel';
            $msg_id = $appt->id;
            $sub_id = $request->appt_code;
            //dr reply to special msg
        
            //PushNotificationCommon::sendNotification($principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
            PushNotificationCommon::sendNotification($coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
        }





    return response()->json('Deleted');
}

////////////////New Development/////////////////////////
public function SaveDeviceToken(Request $request)
{  $firebase_token = $request->token;
    $push_noti = PushNotificationsTokenModel::where('token', $firebase_token)->where('user_id', $request->user_id)->first();
    if ($push_noti) {
        
        $push_noti = PushNotificationsTokenModel::where('user_id', $request->user_id)->update([
            'token' => $firebase_token,
            'device_type' => $request->device_type]);
            return response()->json($push_noti);
        // user doesn't exist
    
    }
    else {
        $deviceToken = new PushNotificationsTokenModel();
        $deviceToken->user_id = $request->user_id;
        $deviceToken->token = $firebase_token;
        $deviceToken->device_type = $request->device_type;
        $deviceToken->save();
        return response()->json($deviceToken);
    }
}




   
public function getAppointmenDetailsByPrincipal(Request $request)
{
    $date = today()->format('Y-m-d');

    $appointments = ScheduledAppointments::where('scheduled_appointments.principal_code',$request->principal_code)
    ->where('scheduled_appointments.appt_date', '>=', $date)
    ->where('scheduled_appointments.delete',0)
    ->Join('users','users.user_code','scheduled_appointments.coach_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no')
    ->orderBy('scheduled_appointments.appt_date', 'ASC' )
    ->orderByRaw("STR_TO_DATE(scheduled_appointments.time_slot, '%h:%i %p') ASC")
    ->get();
    if($appointments->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$appointments,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data'
        ]);
    
    }
    
   

}
public function getAppointmenDetailsByPrincipalUpcomings(Request $request)
{
    $date = today()->format('Y-m-d');

    $appointments = ScheduledAppointments::where('scheduled_appointments.principal_code',$request->principal_code)->where('scheduled_appointments.status',1)
    ->where('scheduled_appointments.appt_date', '>=', $date)
    ->join('users','users.user_code','scheduled_appointments.coach_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no')
    ->orderBy('scheduled_appointments.appt_date', 'ASC')
    ->orderByRaw("STR_TO_DATE(scheduled_appointments.time_slot, '%h:%i %p') ASC")
    ->take(3)
    ->get();
    if($appointments->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$appointments,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data'
        ]);
    
    }
    
   

}
public function getAppointmenDetailsByCoachUpcomings(Request $request)
{
    $date = today()->format('Y-m-d');

    $appointments = ScheduledAppointments::where('scheduled_appointments.coach_code',$request->coach_code)->where('scheduled_appointments.status',1)
    ->where('scheduled_appointments.delete',0)
    ->where('scheduled_appointments.appt_date', '>=', $date)
    ->join('users','users.user_code','scheduled_appointments.principal_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no')
    ->orderBy('scheduled_appointments.appt_date', 'ASC')
    ->orderByRaw("STR_TO_DATE(scheduled_appointments.time_slot, '%h:%i %p') ASC")
    ->take(3)
    ->get();
    if($appointments->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$appointments,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data',
        ]);
    
    }

}
public function getAppointmenDetailsByCoach(Request $request)
{
    $date = today()->format('Y-m-d');

    $appointments = ScheduledAppointments::where('scheduled_appointments.coach_code',$request->coach_code)
      ->where('scheduled_appointments.delete',0)
    ->where('scheduled_appointments.appt_date', '>=', $date)
    ->join('users','users.user_code','scheduled_appointments.principal_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no')
    ->orderBy('scheduled_appointments.appt_date', 'ASC')
    ->orderByRaw("STR_TO_DATE(scheduled_appointments.time_slot, '%h:%i %p') ASC")
    ->get();
    if($appointments->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$appointments,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data',
        ]);
    
    }

}

public function getAppointmenDetailsByPrincipalApptCode(Request $request)
{

    $appointments = ScheduledAppointments::where('scheduled_appointments.status',1)
    ->where('scheduled_appointments.delete',0)
    ->where('scheduled_appointments.appointments_code',$request->appt_code)
    ->join('users','users.user_code','scheduled_appointments.coach_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no','users.title')
    
    ->get();
    if($appointments->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$appointments,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data'
        ]);
    
    }
    
   

}

public function getAppointmenDetailsByPrincipalRatings(Request $request)
{

    $appointments = ScheduledAppointments::where('scheduled_appointments.appointments_code',$request->appt_code)
    ->join('users','users.user_code','scheduled_appointments.coach_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no','users.title')
    
    ->get();
    if($appointments->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$appointments,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data'
        ]);
    
    }
    
   

}
public function getAppointmenDetailsByCoachRatings(Request $request)
{

    $appointments = ScheduledAppointments::where('scheduled_appointments.appointments_code',$request->appt_code)
    ->join('users','users.user_code','scheduled_appointments.principal_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no','users.title')
    
    ->get();
    if($appointments->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$appointments,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data'
        ]);
    
    }
    
   

}

public function getuserNotifications(Request $request)
{

    $notifications = NotificationModel::where('users.user_code',$request->user_code)
    ->join('users','users.id','notifications.user_id')
    ->select('notifications.*')
    ->orderBy('created_at', 'DESC')
    ->get();
    if($notifications->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$notifications,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data'
        ]);
    
    }
    
   

}
public function getuserCountNotifications(Request $request)
{

    $notifications = NotificationModel::where('users.user_code',$request->user_code)
    ->where('notifications.status',0)
    ->join('users','users.id','notifications.user_id')
    ->select('notifications.*')
    ->orderBy('created_at', 'DESC')
    ->get();
    if($notifications->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$notifications,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data'
        ]);
    
    }
    
   

}
public function clearuserNotifications(Request $request)
{

    $notifications = NotificationModel::where('users.user_code',$request->user_code)
    ->where('notifications.status',0)
    ->join('users','users.id','notifications.user_id')
    ->select('notifications.*')
    ->orderBy('created_at', 'DESC')
    ->get();

    for ($i=0; $i <= sizeof($notifications); $i++) {

        $user = NotificationModel::where('id',$notifications[$i]['id'])->first();
        $user->status = 1;
        $user->save();
    }
    
    if($notifications->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$notifications,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data'
        ]);
    
    }
    
   

}
public function deleteAvailability(Request $request)
{
    $availability=CoachAvailabilityModel::where('coach_availability.avail_code',$request->avail_code)->first();

    



    $notifications = CoachAvailabilityModel::where('coach_availability.avail_code',$request->avail_code)->delete();

    $notifications = CoachAvailableDetail::where('coach_availability_detail.avail_code',$request->avail_code)->delete();

    return response()->json([
        'message' =>'success',
       
    ]);
    // if($notifications->isNotEmpty()){
    //     return response()->json([
    //         'message' =>'success',
    //         'data' =>$notifications,
    //     ]);
    
    // }
    // else{
    //     return response()->json([
    //         'message' =>'no_data'
    //     ]);
    
    // }
    
   

}

public function deleteNotifications(Request $request)
{

    $notifications = NotificationModel::where('id',$request->id)->first();
    $notifications->delete();

    return response()->json([
        'message' =>'success',
       
    ]);
    // if($notifications->isNotEmpty()){
    //     return response()->json([
    //         'message' =>'success',
    //         'data' =>$notifications,
    //     ]);
    
    // }
    // else{
    //     return response()->json([
    //         'message' =>'no_data'
    //     ]);
    
    // }
    
   

}

public function getAppointmenDetailsByCoachApptCode(Request $request)
{

    $appointments = ScheduledAppointments::where('scheduled_appointments.appointments_code',$request->appt_code)
    ->join('users','users.user_code','scheduled_appointments.principal_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no')
    ->get();
    if($appointments->isNotEmpty()){
        return response()->json([
            'message' =>'success',
            'data' =>$appointments,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'no_data',
        ]);
    
    }

}
//Token gen
public function AgoraTokenGeneration(Request $request)
{
    $appID = "86bd3ecef7cb48388044ecc22d232f3e";
    $appCertificate = "341cb63cfe6d4ee0be780743f06a4010";
    $channelName = $request->channel_name;
    $uid = 12;
    $role = RtcTokenBuilder::RoleAttendee;
    $expireTimeInSeconds = 3600;
    $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
    $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

    $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, 12, $role, $privilegeExpiredTs);
 
    return response()->json([
        'message' =>'success',
        'data' =>$token,
    ]);
}
public function getLibraryPost(Request $request)
{

    $appointments = PostsModel::where('posts.status',1)
    ->where('sectors.status',1)
    ->join('sectors','sectors.id','posts.category')
    ->select('posts.*','sectors.name','sectors.details','sectors.image')
    ->get();
   return response()->json($appointments);

}
public function getScheduleById(Request $request)
{

    $appointments = PostsModel::where('posts.status',1)
    ->join('sectors','sectors.id','posts.category')
    ->select('posts.*','sectors.name','sectors.details','sectors.image')
    ->orderBy('created_at', 'DESC')
    ->get();
   return response()->json($appointments);

}
public function getLibraryPostByID(Request $request)
{

    $posts = PostsModel::where('posts.post_code',$request->post_code)
    ->where('posts.status',1)
    ->join('sectors','sectors.id','posts.category')
    ->join('users','users.id','posts.author_id')
    ->select('posts.*','sectors.name','sectors.details','sectors.image','users.first_name','users.last_name','users.profile_image')
    ->get();
   return response()->json($posts);

}
public function getLibraryPostBySearch(Request $request)
{
    $search_text = $request->searchText;

    $library = PostsModel::Where('posts.status',1)
    ->where('sectors.status',1)
    ->where(function($query) use ($search_text) {
        return $query->orWhere("posts.title","like","%".$search_text."%")
        ->orWhere("sectors.name","like","%".$search_text."%");
     })
    ->join('sectors','sectors.id','posts.category')
    ->select('posts.*','sectors.name','sectors.details','sectors.image')
    ->orderBy('created_at', 'DESC')
    ->get();
   return response()->json($library);

}
public function getLibraryPostBySearchCategory(Request $request)
{
    $search_text = $request->searchText;

    $library = PostsModel::Where('posts.status',1)
    ->where('sectors.status',1)
    ->where(function($query) use ($search_text) {
        return $query->orWhere("sectors.name","like","%".$search_text."%");
     })
    ->join('sectors','sectors.id','posts.category')
    ->select('posts.*','sectors.name','sectors.details','sectors.image')
    ->orderBy('created_at', 'DESC')
    ->get();
   return response()->json($library);

}

public function getLibraryPostDailyDose(Request $request)
{

    $appointments = PostsModel::where('posts.is_daily_dose',1)
    ->where('sectors.status',1)
    ->join('sectors','sectors.id','posts.category')
    ->select('posts.*','sectors.name','sectors.details','sectors.image')
    ->orderBy('created_at', 'DESC')
    ->take($request->searchText)
    ->get();
   return response()->json($appointments);

}

public function getUserDetails(Request $request)
{

    $users = Users::where('users.user_code',$request->user_code)
    ->get();
   return response()->json($users);

}
public function scheduleManage(Request $request){
 
    // $this->validate($request, [
    //     'duration' => 'sometimes|required|numeric|gt:0',
    //     'serial_day' => 'required|numeric|gt:0',
    //     'start_time' => 'sometimes|required',
    //     'end_time' => 'sometimes|required'
    // ]);

    // $doctor = Doctor::findOrFail(Auth::guard('doctor')->user()->id);
    $users =  $appointment = CoachAvailabilityModel::where('coach_availability.coach_code',$request->coach_code)
    ->whereBetween('coach_availability_detail.date', [ $request->from_date,  $request->to_date])
    ->join('coach_availability_detail','coach_availability_detail.avail_code','coach_availability.avail_code')
    ->first();
  

    if($users){
        return response()->json([
            'message' =>'unsuccess',
        ]);
        
    }
    else{
   
        $start_time_15 = Carbon::parse($request->start_time);
        $start_time_30 = Carbon::parse($request->start_time);
        $start_time_60 = Carbon::parse($request->start_time);
        
        $end_time = Carbon::parse($request->end_time);
        $minute_subs_60=substr($request->start_time, 3, 5);

        if($minute_subs_60==30){
            $start_time_60->addMinutes(30);

        }
      

        $start_date=Carbon::parse($request->from_date);
        $end_date=Carbon::parse($request->to_date);
        $total_min = $end_time->diffInMinutes($start_time_15);
        $total_slot_15 = $total_min / 15;
        $total_slot_30 = $total_min / 30;
        $total_slot_60 = $total_min / 60;
        $total_dates = $end_date->diffInDays($start_date);

        $serial_or_slot_15 = [];
        $serial_or_slot_30 = [];
        $serial_or_slot_60 = [];
        $dates_in = [];


        for ($i=1; $i <= $total_slot_15; $i++) {

            array_push($serial_or_slot_15,date('h:i A',strtotime($start_time_15)));
            $start_time_15->addMinutes(15);
        }
        for ($i=1; $i <= $total_slot_30; $i++) {

            array_push($serial_or_slot_30,date('h:i A',strtotime($start_time_30)));
            $start_time_30->addMinutes(30);
        }
        for ($i=1; $i <= $total_slot_60; $i++) {

            array_push($serial_or_slot_60,date('h:i A',strtotime($start_time_60)));
            $start_time_60->addMinutes(60);
        }
            // return $serial_or_slot_60;
        $coach_availability = new CoachAvailabilityModel();
        $coach_availability->avail_code = Uuid::generate(4);
        $coach_availability->coach_code = $request->coach_code;
        $coach_availability->from_date = Carbon::parse($request->from_date);
        $coach_availability->to_date = Carbon::parse($request->to_date);
        $coach_availability->start_time = Carbon::parse($request->start_time)->format('h:i a');
        $coach_availability->end_time = Carbon::parse($request->end_time)->format('h:i a');
        $coach_availability->description = $request->description;
        $coach_availability->slots = $request->slots;
        $coach_availability->save();
        for ($i=0; $i <= $total_dates; $i++) {

            // $details_date =CoachAvailableDetail::where('date', date('Y-m-d',strtotime($start_date)))
            // ->where('status',0)
            // ->first();
            // if($details_date){
            //     $details_date->avail_code = $coach_availability->avail_code;
            //     $details_date->date = date('Y-m-d',strtotime($start_date));
            //     if(in_array(strtoupper(substr($start_date->format('l'), 0, 2)), $request->slots)){

            //         $details_date->status = 1;
            //         $details_date->time_slots_15 = $serial_or_slot_15;
            //         $details_date->time_slots_30 = $serial_or_slot_30;
            //         $details_date->time_slots_60 = $serial_or_slot_60;
            //         }
            //         elseif(count((array)$request->slots)==0){
            //             $details_date->status = 1;
            //             $details_date->time_slots_15 = $serial_or_slot_15;
            //             $details_date->time_slots_30 = $serial_or_slot_30;
            //             $details_date->time_slots_60 = $serial_or_slot_60;
            //         }
            //         else{
            //             // $details_date->time_slots_30 = null;
            //             // $details_date->time_slots_30 = null;
            //             // $details_date->time_slots_60 = null;
            //             // $details_date->status = 0;
            //         }
                
            //     $details_date->save();
            // }
            // else{
                $coach_availability_details = new CoachAvailableDetail();
                $coach_availability_details->avail_code = $coach_availability->avail_code;
                $coach_availability_details->date = date('Y-m-d',strtotime($start_date));
                if(in_array(strtoupper(substr($start_date->format('l'), 0, 2)), $request->slots)){

                    $coach_availability_details->status = 1;
                    $coach_availability_details->time_slots_15 = $serial_or_slot_15;
                    $coach_availability_details->time_slots_30 = $serial_or_slot_30;
                    $coach_availability_details->time_slots_60 = $serial_or_slot_60;
                    }
                    elseif(count((array)$request->slots)==0){
                        $coach_availability_details->status = 1;
                        $coach_availability_details->time_slots_15 = $serial_or_slot_15;
                        $coach_availability_details->time_slots_30 = $serial_or_slot_30;
                        $coach_availability_details->time_slots_60 = $serial_or_slot_60;
                    }
                    else{
                        $coach_availability_details->time_slots_30 = null;
                        $coach_availability_details->time_slots_30 = null;
                        $coach_availability_details->time_slots_60 = null;
                        $coach_availability_details->status = 0;
                    }
                
                $coach_availability_details->save();
            // }
        

                    
    
        //  array_push($dates_in,);

        //  if($request->slots->contains(strtoupper(substr($start_date->format('l'), 0, 2)))){


            $start_date->addDays(1);


        }
     
        

        // if()

        // return $serial_or_slot;
        // $coach_availability = new CoachAvailabilityModel();
        // $coach_availability->avail_code = Uuid::generate(4);
        // $coach_availability->coach_code = $request->coach_code;
        // $coach_availability->from_date = Carbon::parse($request->from_date);
        // $coach_availability->to_date = Carbon::parse($request->to_date);
        // $coach_availability->start_time = Carbon::parse($request->start_time)->format('h:i a');
        // $coach_availability->end_time = Carbon::parse($request->end_time)->format('h:i a');
        // $coach_availability->slots = $serial_or_slot;
        // $coach_availability->save();

    

        return response()->json([
            'message' =>'success',
        ]);
    }
}
public function getCoachAvailabilityList(Request $request)
{

    $users = CoachAvailabilityModel::where('coach_availability.coach_code',$request->coach_code)
    ->get();
   return response()->json($users);

}
public function getCoachAvailabilityAppt(Request $request)
{


   $alreadyBooked=false;
// for($i = 0; $i < sizeof($request->slot); $i++){
//     $users =  $appointment = ScheduledAppointments::where('scheduled_appointments.coach_code',$request->coach_code)->Where('appt_date','=',$request->date)
//     ->where('time_slot','=',$request->slot[$i])
//     ->first();
//     if($users){
//         $alreadyBooked=true;
        
//     }
    
// }
$users =  $appointment = ScheduledAppointments::where('scheduled_appointments.principal_code',$request->principal_code)->Where('appt_date','=',$request->date)
->where('status','!=',3)
->where('time_slot','=',$request->slot)

->first();

if($users){
    $alreadyBooked=true;
    
}
return response()->json([
    'message' =>$alreadyBooked?'unsuccess':'success',
]);
   
  
  

}

public function getAlreadyBookedSlot(Request $request)
{


   $alreadyBooked=false;
    $users =  $appointment = ScheduledAppointments::where('scheduled_appointments.coach_code',$request->coach_code)->Where('appt_date','=',$request->date)
    ->where('status','=',1)
    ->get();

if($users){
    $alreadyBooked=true;
    
}
return response()->json([
    'message' =>$alreadyBooked?'unsuccess':'success',
    'data' =>$users,
]);
   
  
  

}
public function getAppointmentTimeSlots(Request $request)
{
    $user = CoachAvailabilityModel::select('coach_availability_detail.time_slots_15','coach_availability_detail.time_slots_30','coach_availability_detail.time_slots_60','coach_availability.start_time','coach_availability.end_time')
    ->where('coach_code','=',$request->coach_code)
    ->where('coach_availability_detail.date','=',$request->date)
    ->join('coach_availability_detail','coach_availability_detail.avail_code','coach_availability.avail_code')
    // ->whereBetween($request->date, ['coach_availability.from_date', 'coach_availability.to_date'])
    ->first();

    
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

    if($user->count()>0){
        if($request->duration==15){
            
            return response()->json($slotsDecode_15);
        }
        elseif($request->duration==30){
            return response()->json($slotsDecode_30);
        }
        elseif($request->duration==60){
            
           return response()->json($slotsDecode_60);
        }
    }
    else{
        return response()->json(null);
    }
    
   

}

public function getCoachTimeSlotToEdit(Request $request)
{
    $user = CoachAvailabilityModel::select('coach_availability_detail.time_slots_15','coach_availability_detail.time_slots_30','coach_availability_detail.time_slots_60','coach_availability.start_time','coach_availability.end_time')
    ->where('coach_code','=',$request->coach_code)
    ->where('coach_availability_detail.avail_code','=',$request->avail_code)
    ->where('coach_availability_detail.date','=',$request->date)
    ->join('coach_availability_detail','coach_availability_detail.avail_code','coach_availability.avail_code')
    // ->whereBetween($request->date, ['coach_availability.from_date', 'coach_availability.to_date'])
    ->first();

    
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

    if($user->count()>0){
       if($request->duration==30){
            return response()->json($slotsDecode_30);
        }
        elseif($request->duration==60){
            
           return response()->json($slotsDecode_60);
        }
    }
    else{
        return response()->json(null);
    }
    
   

}
public function updateCoachAvailableDate(Request $request)
{

    // $user = CoachAvailableDetail::Where('coach_code','=',$request->coach_code)
    // ->where('coach_availability_detail.date','=',$request->date)
    // ->join('coach_availability','coach_availability_detail.avail_code','coach_availability.avail_code')
    // // ->whereBetween($request->date, ['coach_availability.from_date', 'coach_availability.to_date'])
    // ->first();

    // if($request->duration==30){
    //     $user->time_slots_30 = '';
    //     $user->save();
    // }
    // if($request->duration==60){
    //     $user->time_slots_60 = json_encode($request->time_slots_60);
    //     $user->save();
    // }

    // $coachAvailability = CoachAvailabilityModel::where('coach_availability.coach_code',$request->coach_code)
    // ->first();

    $coachAvailability_save = CoachAvailableDetail::where('coach_availability_detail.avail_code',$request->avail_code)
    ->where('coach_availability_detail.date',$request->date)
    ->first();



    
  if($request->duration==30){
    $final_available_slots = array_values($request->time_slots_30);
    usort($final_available_slots, function($a, $b) {
        return (strtotime($a) > strtotime($b));
    });
        $coachAvailability_save->time_slots_30 =$final_available_slots;
        $coachAvailability_save->save();
    }
    if($request->duration==60){
        $final_available_slots = array_values($request->time_slots_60);
    usort($final_available_slots, function($a, $b) {
        return (strtotime($a) > strtotime($b));
    });
        $coachAvailability_save->time_slots_60 = $final_available_slots;
        $coachAvailability_save->save();
    }
   


    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$coachAvailability_save,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
// public function getAppointmentTimeSlots(Request $request)
// {
//     $user = CoachAvailabilityModel::select('coach_availability_detail.time_slots_15','coach_availability_detail.time_slots_30','coach_availability_detail.time_slots_60','coach_availability.start_time','coach_availability.end_time')
//     ->where('coach_code','=',$request->coach_code)
//     ->where('coach_availability_detail.date','=',$request->date)
//     ->join('coach_availability_detail','coach_availability_detail.avail_code','coach_availability.avail_code')
//     // ->whereBetween($request->date, ['coach_availability.from_date', 'coach_availability.to_date'])
//     ->first();

    
//     // return $user[0]['time_slots'];
//     $available_slots = array();
//     $final_available_slots = array();
//     $time_slots = array();
//     $time_slots = array();
//     // // $time_slots[]=$user['time_slots_15'];
//     // $arrays[] =  (array) $user['time_slots_15'];
//     $slotsDecode_15=json_decode($user['time_slots_15']);
//     $slotsDecode_30=json_decode($user['time_slots_30']);
//     $slotsDecode_60=json_decode($user['time_slots_60']);
// //    return json_decode($user['time_slots']);

//     if($user->count()>0){
//         if($request->duration==15){
//             for ($i = 0; $i < count((array)json_decode($user['time_slots_15'])); $i++) {
                
    
//                     $appointment = ScheduledAppointments::Where('appt_date','=',$request->date)
//                      ->where('status','=',1)
//                      ->where('coach_code','=',$request->coach_code)
//                     ->orWhere('status','=',0)
                    
                   
//                     ->get();
                    

//                     $available_slots[]=$slotsDecode_15[$i];
//                     for ($j = 0; $j < count($appointment); $j++) {
//                         $appointment_start_time= Carbon::createFromFormat('H:i:a',$appointment[$j]['time_slot'])->format('H:i');
//                         $slot_15_val=Carbon::createFromFormat('H:i:a',$slotsDecode_15[$i])->format('H:i');
                        
//                         $endcarboon = Carbon::parse($appointment_start_time);
//                         $appointment_end_time;
//                         if($appointment[$j]['duration']==15){
//                             $appointment_end_time= $endcarboon->addMinutes(15)->format('H:i');
                           
//                         }
//                         elseif($appointment[$j]['duration']==30){
//                             $appointment_end_time= $endcarboon->addMinutes(30)->format('H:i');
//                         }
//                         elseif($appointment[$j]['duration']==60){
//                             $appointment_end_time= $endcarboon->addMinutes(60)->format('H:i');
//                         }
                       

//                     //   return $appointment[$j]['time_slot']<= date('h:i:a',strtotime($slotsDecode_15[$i])) && date('h:i:a',strtotime($slotsDecode_15[$i])) <=$appointment[$j]['time_slot'];
                       
//                         if($slot_15_val >= $appointment_start_time && $slot_15_val < $appointment_end_time){
                           
//                             if (($key = array_search($slotsDecode_15[$i], $available_slots)) !== false) {
//                                 unset($available_slots[$key]);
//                             }



//                         }
//                         $new_15 = Carbon::parse($slot_15_val);
//                         $new_15->addMinutes(15)->format('H:i');
//                         if($new_15 >= $appointment_start_time && $new_15 < $appointment_end_time){
                           
//                             if (($key = array_search($slotsDecode_15[$i], $available_slots)) !== false) {
//                                 unset($available_slots[$key]);
//                             }



//                         }
                       
//                     }

//             }
//             $final_available_slots = array_values($available_slots);
            
//             return response()->json($final_available_slots);
//         }
//         elseif($request->duration==30){
            
//             for ($i = 0; $i < count((array)json_decode($user['time_slots_30'])); $i++) {
                
    
//                 $appointment = ScheduledAppointments::Where('appt_date','=',$request->date)
//                 ->where('coach_code','=',$request->coach_code)
//                 ->get();
                

//                 $available_slots[]=$slotsDecode_30[$i];
//                 for ($j = 0; $j < count($appointment); $j++) {
//                     $appointment_start_time= Carbon::createFromFormat('H:i:a',$appointment[$j]['time_slot'])->format('H:i');
//                     $slot_30_val=Carbon::createFromFormat('H:i:a',$slotsDecode_30[$i])->format('H:i');
                    
//                     $endcarboon = Carbon::parse($appointment_start_time)->format('H:i');
//                     $appointment_end_time;
//                     $dateCreateFormat=$request->date.' '.$endcarboon;

//                     // return Carbon::parse($dateCreateFormat)->addMinutes(15);
//                     if($appointment[$j]['duration']==15){
//                         $appointment_end_time= Carbon::parse($dateCreateFormat)->addMinutes(15);
                       
//                     }
//                     elseif($appointment[$j]['duration']==30){
//                         $appointment_end_time= Carbon::parse($dateCreateFormat)->addMinutes(15);
//                     }
//                     elseif($appointment[$j]['duration']==60){
//                         $appointment_end_time= Carbon::parse($dateCreateFormat)->addMinutes(15);
//                     }
                   

//                 //   return $appointment[$j]['time_slot']<= date('h:i:a',strtotime($slotsDecode_15[$i])) && date('h:i:a',strtotime($slotsDecode_15[$i])) <=$appointment[$j]['time_slot'];
               
//                     if($slot_30_val >= $appointment_start_time && $slot_30_val < $appointment_end_time){
                       
//                         if (($key = array_search($slotsDecode_30[$i], $available_slots)) !== false) {
//                             unset($available_slots[$key]);
//                         }



//                     }
//                     $dateCreateFormat=$request->date.' '.$slot_30_val;
//                     $slot_end= Carbon::createFromFormat('H:i:a',$slot_30_val)->format('H:i');
//                     $new_15 = Carbon::parse($slot_end);
//                     $new_15->addMinutes(30)->format('H:i');
                  
//                     if($new_15 >= $appointment_end_time && $new_15 < $appointment_start_time){
                        
                       
//                         if (($key = array_search($slotsDecode_30[$i], $available_slots)) !== false) {
//                             unset($available_slots[$key]);
//                         }



//                     }
//                 }

//         }
//         $final_available_slots = array_values($available_slots);
        
//         return response()->json($final_available_slots);
//         }
//         elseif($request->duration==60){
            
//             for ($i = 0; $i < count((array)json_decode($user['time_slots_60'])); $i++) {
                
    
//                 $appointment = ScheduledAppointments::Where('appt_date','=',$request->date)
//                 ->where('coach_code','=',$request->coach_code)
//                 ->get();
                

//                 $available_slots[]=$slotsDecode_60[$i];
//                 for ($j = 0; $j < count($appointment); $j++) {
//                     $appointment_start_time= Carbon::createFromFormat('H:i:a',$appointment[$j]['time_slot'])->format('H:i');
//                     $slot_30_val=Carbon::createFromFormat('H:i:a',$slotsDecode_60[$i])->format('H:i');
                    
//                     $endcarboon = Carbon::parse($appointment_start_time);
//                     $appointment_end_time=null;
//                     if($appointment[$j]['duration']==15){
//                         $appointment_end_time= $endcarboon->addMinutes(15)->format('H:i');
                       
//                     }
//                     elseif($appointment[$j]['duration']==30){
//                         $appointment_end_time= $endcarboon->addMinutes(30)->format('H:i');
//                     }
//                     elseif($appointment[$j]['duration']==60){
//                         $appointment_end_time= $endcarboon->addMinutes(60)->format('H:i');
//                     }
                   

//                 //   return $appointment[$j]['time_slot']<= date('h:i:a',strtotime($slotsDecode_15[$i])) && date('h:i:a',strtotime($slotsDecode_15[$i])) <=$appointment[$j]['time_slot'];
                   
//                     if($slot_30_val >= $appointment_start_time && $slot_30_val < $appointment_end_time){
                       
//                         if (($key = array_search($slotsDecode_60[$i], $available_slots)) !== false) {
//                             unset($available_slots[$key]);
//                         }



//                     }
//                     else{

//                     }
//                     $new_15 = Carbon::parse($slot_30_val);
//                     $new_15->addMinutes(60)->format('H:i');
//                     if($new_15 >= $appointment_start_time && $new_15 < $appointment_end_time){
                       
//                         if (($key = array_search($slotsDecode_60[$i], $available_slots)) !== false) {
//                             unset($available_slots[$key]);
//                         }



//                     }
//                     else{

//                     }
//                 }

//         }
//         $final_available_slots = array_values($available_slots);
        
//         return response()->json($final_available_slots);
//         }
//     }
//     else{
//         return response()->json(null);
//     }
    
   

// }
public function getCoachList(Request $request)
{

    $users = Users::where('users.user_type','coach')
    ->where('users.status',1)
    ->orderBy('users.first_name', 'ASC')
    ->get();
   return response()->json($users);

}
public function getPrincipalList(Request $request)
{

    // $users = Users::where("users.first_name","like","%".$request->searchText."%")
    // ->orWhere("users.last_name","like","%".$request->searchText."%")
    // ->where('users.user_type','principal')
    // ->where('users.status',1)
    // ->get();
    $search=$request->searchText;
    $users = Users::where('users.user_type','principal')
    ->where('users.status',1)
    // ->where("users.first_name","like","%".$request->searchText."%")
    // ->orWhere("users.last_name","like","%".$request->searchText."%")
    ->where(function($query) use ($search) {
        return $query->orWhere("users.first_name","like","%".$search."%")
        ->orWhere("users.last_name","like","%".$search."%");
     })->orderBy('users.first_name', 'ASC')->get();
   return response()->json($users);

}
public function getCoachesList(Request $request)
{
    $search=$request->searchText;
    $users = Users::where('users.user_type','coach')
    ->where('users.status',1)
    // ->where("users.first_name","like","%".$request->searchText."%")
    // ->orWhere("users.last_name","like","%".$request->searchText."%")
    ->where(function($query) use ($search) {
        return $query->orWhere("users.first_name","like","%".$search."%")
        ->orWhere("users.last_name","like","%".$search."%");
     })
     ->orderBy('users.first_name', 'ASC')
    ->get();
   return response()->json($users);

}
public function updateUserDetails(Request $request)
{
     $final_available_slots = array();
    $user = Users::where('user_code',$request->user_code)->first();
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->title = $request->title;
    $user->school = $request->school;
    $user->mobile_no = $request->mobile_no;
    $user->email = $request->email;
    $user->district = $request->district;
    $user->save();
    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$user,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function passwordChange(Request $request)
{
     $final_available_slots = array();
    $user = Users::where('user_code',$request->user_code)->first();
    $user->password = Hash::make($request->password);
    $user->save();
    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$user,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function saveCallDetails(Request $request)
{
    $user = ScheduledAppointments::where('appointments_code',$request->appt_code)->first();
    $user->status = 4;
    $user->save();

    $user = new CallHostoryModel();
    $user->appointment_id = $request->appt_code;
    $user->call_start_at = $request->call_start_at;
    $user->call_end_at = $request->call_end_at;
    $user->call_duration = $request->call_duration;
    $user->call_date = $request->call_date;
    $user->is_video = 0;
    $user->status = $request->both_joined;
    $user->save();
    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$user,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function savePrincipalAppoinment(Request $request)
{
    $final_available_slots = array();
    $uuidd=Uuid::generate(4);
    $user = new ScheduledAppointments();
    $user->appointments_code =  $uuidd->string;
    $user->coach_code = $request->coach_code;
    $user->principal_code = $request->principal_code;
    $user->appt_date = $request->appt_date;
    $user->time_slot = $request->time_slot;
    $user->duration = $request->duration;
    $user->status = 1;
    $user->topic = $request->topic;
    $user->message = $request->message;
    $user->save();

    $coachAvailability = CoachAvailableDetail::where('coach_availability.coach_code',$request->coach_code)
    ->where('coach_availability_detail.date',$request->appt_date)
    ->join('coach_availability','coach_availability.avail_code','coach_availability_detail.avail_code')
    ->first();




if($request->duration==60){
    $slotsDecode_60=$coachAvailability['time_slots_60'];
    $slotsDecode_30=$coachAvailability['time_slots_30'];

    $slotsDecode_30_sort = array();

    
    if (($key = array_search($request->time_slot, $slotsDecode_60)) !== false) {
             unset($slotsDecode_60[$key]);
        }
        $final_available_slots = array_values($slotsDecode_60);




        for ($i = 0; $i < count((array)$slotsDecode_30); $i++) {
            if (strtotime($slotsDecode_30[$i]) >= strtotime($request->time_slot) && strtotime($slotsDecode_30[$i]) < strtotime('+60 minutes', strtotime($request->time_slot)))
            {
                if (($key = array_search($slotsDecode_30[$i], $slotsDecode_30)) !== false) {
                    unset($slotsDecode_30[$key]);
               }
            }
            else{
               
            }

        }

   



        $slotsDecode_30_sort = array_values($slotsDecode_30);

        $coachAvailability_save = CoachAvailableDetail::where('coach_availability_detail.avail_code',$coachAvailability->avail_code)
        ->where('coach_availability_detail.date',$request->appt_date)
        ->first();



        
        $coachAvailability_save->time_slots_60 = $final_available_slots;
        $coachAvailability_save->time_slots_30 = $slotsDecode_30_sort;
        $coachAvailability_save->save();
     

}
if($request->duration==30){
    $slotsDecode_30=$coachAvailability['time_slots_30'];
    $slotsDecode_60=$coachAvailability['time_slots_60'];

    $slotsDecode_60_sort = array();
    $slotsDecode_60_sorted = array();

    if (($key = array_search($request->time_slot, $slotsDecode_30)) !== false) {
             unset($slotsDecode_30[$key]);
        }
        

        for ($i = 0; $i < count((array)$slotsDecode_60); $i++) {
            // if (strtotime($slotsDecode_60[$i]) >= strtotime($request->time_slot) && strtotime($slotsDecode_60[$i]) < strtotime('+30 minutes', strtotime($request->time_slot)))
           if (strtotime($request->time_slot) >= strtotime($slotsDecode_60[$i]) && strtotime($request->time_slot) < strtotime('+60 minutes', strtotime($slotsDecode_60[$i])))
            {
                if (($key = array_search($slotsDecode_60[$i], $slotsDecode_60)) !== false) {
                    unset($slotsDecode_60[$key]);
               }
            }
            // $slotsDecode_60_sort = array_values($slotsDecode_60);
            // // return $slotsDecode_60;
            // if (strtotime('+30 minutes', strtotime($slotsDecode_60_sort[$i])) >=strtotime($request->time_slot)
            //  && strtotime('+30 minutes', strtotime($slotsDecode_60_sort[$i])) < strtotime('+30 minutes', strtotime($request->time_slot)))
            // {
            //     if (($key = array_search($slotsDecode_60_sort[$i], $slotsDecode_60_sort)) !== false) {
            //         unset($slotsDecode_60_sort[$key]);
            //    }
            // }
            else{
               
            }

        }

   



        $slotsDecode_60_sorted = array_values($slotsDecode_60);
        // return $slotsDecode_60_sorted;




    $final_available_slots = array_values($slotsDecode_30);
    $coachAvailability_save = CoachAvailableDetail::where('coach_availability_detail.avail_code',$coachAvailability->avail_code)
    ->where('coach_availability_detail.date',$request->appt_date)
    ->first();
    $coachAvailability_save->time_slots_30 = $final_available_slots;
     $coachAvailability_save->time_slots_60 = $slotsDecode_60_sorted;
    $coachAvailability_save->save();


}
  


    

    $coach = Users::where('user_code',$request->coach_code)->first();

    $principal = Users::where('user_code',$request->principal_code)->first();

    $noty_msg_body = $principal->first_name . ' ' . $principal->last_name.' scheduled a new '.$request->duration.'M call on '.Carbon::parse($user->appt_date)->format('m-d-Y').' at '.$request->time_slot;
    $noty_msg_title = 'New Appointment Scheduled';
    $click_action = 'https://admin.theprincipalsclub.com';
    $msg_type = 'new_appointment_request';
    $msg_id = $user->id;
    $sub_id = $uuidd->string;
    //dr reply to special msg

    $noty_msg_body1 = 'You have a successfully sent a appointment ' . $coach->first_name . ' ' . $coach->last_name;
    $noty_msg_title1 = 'New Appointment Scheduled';
    $click_action1 = 'https://admin.theprincipalsclub.com';
    $msg_type1 = 'new_appointment_request';
    $msg_id1 = $user->id;
    $sub_id1 = $uuidd->string;

    PushNotificationCommon::sendNotification($coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

    //PushNotificationCommon::sendNotification($coach->id, $noty_msg_body1, $noty_msg_title1, $click_action1, $msg_type1, $msg_id1, $sub_id1);
    

    // $principal_data = ScheduledAppointments::where('scheduled_appointments.appointments_code', $user->appointments_code)
    // ->join('users','users.user_code','scheduled_appointments.principal_code')
    // ->select('scheduled_appointments.*','users.first_name','users.last_name','users.email')
    // ->first();
    // $coach_data = ScheduledAppointments::where('scheduled_appointments.appointments_code', $user->appointments_code)
    // ->join('users','users.user_code','scheduled_appointments.coach_code')
    // ->select('scheduled_appointments.*','users.first_name','users.last_name','users.email')
    // ->first();
    // $data = [];
    // \Mail::send('emails.email', $data, function($message) use($principal_data,$coach_data)
    // {
    //     $filename = "assets/invite.ics";
    //     $meeting_duration = (60 * 15); // 2 hours
    //     $meetingstamp = strtotime( '01-11-2022 11:11:11' . "UTC");
    //     $dtstart = gmdate('Ymd\THis\Z', strtotime($principal_data->appt_date.' '.'01:00:00'));
    //     $dtend =  gmdate('Ymd\THis\Z', strtotime($principal_data->appt_date.' '.'02:00:00'));
    //     $todaystamp = gmdate('Ymd\THis\Z');
    //     $uid = date('Ymd').'T'.date('His').'-'.rand().'@gmail.com';
    //     $description = 'Schedule Meeting';
    //     $location = "Principal's Club App";
    //     $titulo_invite = $coach_data->first_name.' '."Accept Scheduled Meeting";
    //     $organizer = "CN=Organizer name:".$coach_data->email;

    //     // ICS
    //     $mail[0]  = "BEGIN:VCALENDAR";
    //     $mail[1] = "PRODID:-//Google Inc//Google Calendar 70.9054//EN";
    //     $mail[2] = "VERSION:2.0";
    //     $mail[3] = "CALSCALE:GREGORIAN";
    //     $mail[4] = "METHOD:REQUEST";
    //     $mail[5] = "BEGIN:VEVENT";
    //     $mail[6] = "DTSTART;TZID=America/Sao_Paulo:" . $dtstart;
    //     $mail[7] = "DTEND;TZID=America/Sao_Paulo:" . $dtend;
    //     $mail[8] = "DTSTAMP;TZID=America/Sao_Paulo:" . $todaystamp;
    //     $mail[9] = "UID:" . $uid;
    //     $mail[10] = "ORGANIZER;" . $organizer;
    //     $mail[11] = "CREATED:" . $todaystamp;
    //     $mail[12] = "DESCRIPTION:" . $description;
    //     $mail[13] = "LAST-MODIFIED:" . $todaystamp;
    //     $mail[14] = "LOCATION:" . $location;
    //     $mail[15] = "SEQUENCE:0";
    //     $mail[16] = "STATUS:CONFIRMED";
    //     $mail[17] = "SUMMARY:" . $titulo_invite;
    //     $mail[18] = "TRANSP:OPAQUE";
    //     $mail[19] = "END:VEVENT";
    //     $mail[20] = "END:VCALENDAR";

    //     $mail = implode("\r\n", $mail);
    //     header("text/calendar");
    //     file_put_contents($filename, $mail);

    //     $message->subject('The principals club Meeting');
    //     $message->to($principal_data->email);
    //     $message->attach($filename, array('mime' => "text/calendar"));
    // });

    // \Mail::send('emails.email', $data, function($message) use($principal_data,$coach_data)
    // {
    //     $filename = "assets/invite.ics";
    //     $meeting_duration = (60 * 15); // 2 hours
    //     $meetingstamp = strtotime( '01-11-2022 11:11:11' . "UTC");
    //     $dtstart = gmdate('Ymd\THis\Z', strtotime($principal_data->appt_date.' '.'01:00:00'));
    //     $dtend =  gmdate('Ymd\THis\Z', strtotime($principal_data->appt_date.' '.'02:00:00'));
    //     $todaystamp = gmdate('Ymd\THis\Z');
    //     $uid = date('Ymd').'T'.date('His').'-'.rand().'@gmail.com';
    //     $description = 'Schedule Meeting';
    //     $location = "Principal's Club App";
    //     $titulo_invite = $principal_data->first_name.' '."Sent Scheduled Meeting";
    //     $organizer = "CN=Organizer name:".$principal_data->email;

    //     // ICS
    //     $mail[0]  = "BEGIN:VCALENDAR";
    //     $mail[1] = "PRODID:-//Google Inc//Google Calendar 70.9054//EN";
    //     $mail[2] = "VERSION:2.0";
    //     $mail[3] = "CALSCALE:GREGORIAN";
    //     $mail[4] = "METHOD:REQUEST";
    //     $mail[5] = "BEGIN:VEVENT";
    //     $mail[6] = "DTSTART;TZID=America/Sao_Paulo:" . $dtstart;
    //     $mail[7] = "DTEND;TZID=America/Sao_Paulo:" . $dtend;
    //     $mail[8] = "DTSTAMP;TZID=America/Sao_Paulo:" . $todaystamp;
    //     $mail[9] = "UID:" . $uid;
    //     $mail[10] = "ORGANIZER;" . $organizer;
    //     $mail[11] = "CREATED:" . $todaystamp;
    //     $mail[12] = "DESCRIPTION:" . $description;
    //     $mail[13] = "LAST-MODIFIED:" . $todaystamp;
    //     $mail[14] = "LOCATION:" . $location;
    //     $mail[15] = "SEQUENCE:0";
    //     $mail[16] = "STATUS:CONFIRMED";
    //     $mail[17] = "SUMMARY:" . $titulo_invite;
    //     $mail[18] = "TRANSP:OPAQUE";
    //     $mail[19] = "END:VEVENT";
    //     $mail[20] = "END:VCALENDAR";

    //     $mail = implode("\r\n", $mail);
    //     header("text/calendar");
    //     file_put_contents($filename, $mail);

    //     $message->subject('The principals club Meeting');
    //     $message->to($coach_data->email);
    //     $message->attach($filename, array('mime' => "text/calendar"));
    // });

    if($user){
        return response()->json([
            'message' =>'success',
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'unsuccess',
        ]);
    
    }

}

public function getChatMessage(Request $request)
{

    $chats = ChatMessagesModel::where('chat_messages.principal_code',$request->principal_code)
    ->where('chat_messages.coach_code',$request->coach_code )
    ->first();
    if($chats){
        return response()->json([
            'message' =>'success',
            'data' => $chats
        ]);
    }
    else{
        $chatCode= Uuid::generate(4);

        $chatMessage = new ChatMessagesModel();
        $chatMessage->chat_code =  $chatCode;
        // $chatMessage->coach_code = $request->coach_code;
        $chatMessage->principal_code = $request->principal_code;
        $chatMessage->principal_code = $request->principal_code;
        $chatMessage->status = 1;
        $chatMessage->save();


        $chatMessagess = ChatMessagesModel::where('chat_messages.chat_code',$chatCode)->first();
        if($chatMessage){
            return response()->json([
                'message' =>'success',
                'data' => $chatMessagess
            ]);
        
        }
        else{
            return response()->json([
                'message' =>'unsuccess',
            ]);
        
        }
    }


}

public function getChatMessageByCode(Request $request)
{

    $chats = ChatMessagesModel::where('chat_messages.chat_code',$request->chat_code)
    ->first();
        return response()->json([
            'message' =>'success',
            'data' => $chats
        ]);

    


}

public function getChatNewCoach(Request $request)
{

    $chats = ChatMessagesModel::where('chat_messages.coach_code','=',null)
    ->join('users','users.user_code','chat_messages.principal_code')
    ->select('users.profile_image','users.first_name','users.last_name','chat_messages.*')
    ->orderBy('created_at', 'DESC')
    ->get();
  
    return response()->json([
        'message' =>'success',
        'data' => $chats
    ]);


}
public function getChatMessagesCoach(Request $request)
{

    $chats = ChatMessagesModel::where('chat_messages.chat_code','=',$request->chat_code)
    ->join('users','users.user_code','chat_messages.principal_code')
    ->select('users.profile_image','users.first_name','users.last_name','chat_messages.*')
    ->first();
  
    return response()->json([
        'message' =>'success',
        'data' => $chats
    ]);


}
public function coachEnrollChatQuestion(Request $request)
{

    $chatMessage = ChatMessagesModel::where('chat_messages.chat_code',$request->chat_code)->first();
    $chatMessage->coach_code = $request->coach_code;
    $chatMessage->save();

    
    $coach = Users::where('user_code',$request->coach_code)->first();

    $principal = Users::where('user_code',$chatMessage->principal_code)->first();

    $noty_msg_body = 'You have agreed to answer the Coaching Question of ' . $principal->first_name . ' ' . $principal->last_name;
    $noty_msg_title = 'Accepted Chat Question';
    $click_action = 'https://admin.theprincipalsclub.com';
    $msg_type = 'chat_request_accept_coach';
    $msg_id = $chatMessage->id;
    $sub_id = $request->chat_code;
    //dr reply to special msg

    $noty_msg_body1 =  'Coach '.$coach->first_name . ' ' . $coach->last_name.' has reviewed your question and will respond to you shortly. ';
    $noty_msg_title1 = 'Question Reviewed';
    $click_action1 = 'https://admin.theprincipalsclub.com';
    $msg_type1 = 'chat_request_accept_coach';
    $msg_id1 = $chatMessage->id;
    $sub_id1 = $request->chat_code;

    PushNotificationCommon::sendNotification($coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

    PushNotificationCommon::sendNotification($principal->id, $noty_msg_body1, $noty_msg_title1, $click_action1, $msg_type1, $msg_id1, $sub_id1);
    return response()->json([
        'message' =>'success',
        'data' => $chatMessage
    ]);


}

public function getChatOngoingCoach(Request $request)
{

    $chats = ChatMessagesModel::where('chat_messages.coach_code',$request->coach_code)
    ->join('users','users.user_code','chat_messages.principal_code')
    ->select('users.profile_image','users.first_name','users.last_name','chat_messages.*')
    ->orderBy('updated_at', 'DESC')
    ->get();
  
    return response()->json([
        'message' =>'success',
        'data' => $chats
    ]);


}
public function getPrincipalChatMessage(Request $request)
{


    if($request->is_initiate=='false'){
        $chats = ChatMessagesModel::where('chat_messages.chat_code',$request->chat_code)
        ->first();

        return response()->json([
            'message' =>'successsss',
            'data' => $chats
        ]);
    }
    else{
        $chatCode= Uuid::generate(4);

        $chatMessage = new ChatMessagesModel();
        $chatMessage->chat_code =  $chatCode;
        // $chatMessage->coach_code = $request->coach_code;
        $chatMessage->principal_code = $request->principal_code;
        $chatMessage->description  = $request->description;
        $chatMessage->message_subject  = $request->message_subject;
        $chatMessage->status = 1;
        $chatMessage->save();


        $chatMessagess = ChatMessagesModel::where('chat_messages.chat_code',$chatCode)->first();
       
        if($chatMessage){
            return response()->json([
                'message' =>'success',
                'data' => $chatMessagess
            ]);
        
        }
        else{
            return response()->json([
                'message' =>'unsuccess',
            ]);
        
        }
    }


}

public function sendNotificationsToCoach(Request $request)
{



      


        $chatMessagess = ChatMessagesModel::where('chat_messages.chat_code',$request->chat_code)->first();
        $principal = Users::where('user_code',$chatMessagess->principal_code)->first();
        $users = Users::where('user_type','coach')->get();


                for ($i=1; $i <= sizeof($users); $i++) {
               

                   
                
                    $noty_msg_body = $principal->first_name . ' ' . $principal->last_name.' has posted a new question';
                    $noty_msg_title = 'New Question Posted';
                    $click_action = 'https://admin.theprincipalsclub.com';
                    $msg_type = 'new_question_posted';
                    $msg_id = $chatMessagess->id;
                    $sub_id = $request->chat_code;
                    //dr reply to special msg
                
                 
                
                    PushNotificationCommon::sendNotification($users[$i]['id'], $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
                  \Log::info("Send Notification >>>>> ");
                \Log::info($users[$i]['first_name']);
                 }
        if($chatMessage){
            return response()->json([
                'message' =>'success',
                'data' => $chatMessagess
            ]);
        
        }
        else{
            return response()->json([
                'message' =>'unsuccess',
            ]);
        
        }
    


}

public function UpdateChatMessage(Request $request)
{
    // return $request;
    $chatMessage = ChatMessagesModel::where('chat_messages.chat_code',$request->chat_code)->first();
    $chatMessage->chat_hostory = $request->chat_hostory;
    $chatMessage->last_reply = $request->last_reply;
    $chatMessage->coach_replied = $request->coach_replied;
    $chatMessage->principal_replied = $request->principal_replied;
    $chatMessage->save();

    $coach = Users::where('user_code',$chatMessage->coach_code)->first();

    $principal = Users::where('user_code',$chatMessage->principal_code)->first();



    if( $request->user=='coach'){
 

        $noty_msg_body1 =  'Received new message from Coach '.$coach->first_name . ' ' . $coach->last_name.'';
        $noty_msg_title1 = 'Coaching Question';
        $click_action1 = 'https://admin.theprincipalsclub.com';
        $msg_type1 = 'chat_new_message';
        $msg_id1 = $chatMessage->id;
        $sub_id1 = $request->chat_code;

        PushNotificationCommon::sendNotification($principal->id, $noty_msg_body1, $noty_msg_title1, $click_action1, $msg_type1, $msg_id1, $sub_id1);
    }
    if($request->user=='principal'){
   
        $noty_msg_body =  'Received new message from Client '.$principal->first_name . ' ' . $principal->last_name.'';
        $noty_msg_title = 'Coaching Question';
        $click_action = 'https://admin.theprincipalsclub.com';
        $msg_type = 'chat_new_message';
        $msg_id = $chatMessage->id;
        $sub_id = $request->chat_code;

        PushNotificationCommon::sendNotification($coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

    }






    if(true){
        return response()->json([
            'message' =>'success',
            'user' =>$request->use,
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function UpdateStatusOfAppointment(Request $request)
{
    // return $request;
    $chatMessage = ScheduledAppointments::where('scheduled_appointments.appointments_code',$request->appt_code)->first();
    $chatMessage->status = $request->status;
    $chatMessage->save();

    $principal_data = ScheduledAppointments::where('scheduled_appointments.appointments_code',$request->appt_code)
    ->join('users','users.user_code','scheduled_appointments.principal_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.email')
    ->first();
    $coach_data = ScheduledAppointments::where('scheduled_appointments.appointments_code',$request->appt_code)
    ->join('users','users.user_code','scheduled_appointments.coach_code')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.email')
    ->first();
    $data = [];
    \Mail::send('emails.email', $data, function($message) use($principal_data,$coach_data)
    {
        $filename = "assets/invite.ics";
        $meeting_duration = (60 * 15); // 2 hours
        $meetingstamp = strtotime( '01-11-2022 11:11:11' . "UTC");
        $dtstart = gmdate('Ymd\THis\Z', strtotime($principal_data->appt_date.' '.'01:00:00'));
        $dtend =  gmdate('Ymd\THis\Z', strtotime($principal_data->appt_date.' '.'02:00:00'));
        $todaystamp = gmdate('Ymd\THis\Z');
        $uid = date('Ymd').'T'.date('His').'-'.rand().'@gmail.com';
        $description = 'Schedule Meeting';
        $location = "Principal's Club App";
        $titulo_invite = $coach_data->first_name.' '."Accept Scheduled Meeting";
        $organizer = "CN=Organizer name:".$coach_data->email;

        // ICS
        $mail[0]  = "BEGIN:VCALENDAR";
        $mail[1] = "PRODID:-//Google Inc//Google Calendar 70.9054//EN";
        $mail[2] = "VERSION:2.0";
        $mail[3] = "CALSCALE:GREGORIAN";
        $mail[4] = "METHOD:REQUEST";
        $mail[5] = "BEGIN:VEVENT";
        $mail[6] = "DTSTART;TZID=America/Sao_Paulo:" . $dtstart;
        $mail[7] = "DTEND;TZID=America/Sao_Paulo:" . $dtend;
        $mail[8] = "DTSTAMP;TZID=America/Sao_Paulo:" . $todaystamp;
        $mail[9] = "UID:" . $uid;
        $mail[10] = "ORGANIZER;" . $organizer;
        $mail[11] = "CREATED:" . $todaystamp;
        $mail[12] = "DESCRIPTION:" . $description;
        $mail[13] = "LAST-MODIFIED:" . $todaystamp;
        $mail[14] = "LOCATION:" . $location;
        $mail[15] = "SEQUENCE:0";
        $mail[16] = "STATUS:CONFIRMED";
        $mail[17] = "SUMMARY:" . $titulo_invite;
        $mail[18] = "TRANSP:OPAQUE";
        $mail[19] = "END:VEVENT";
        $mail[20] = "END:VCALENDAR";

        $mail = implode("\r\n", $mail);
        header("text/calendar");
        file_put_contents($filename, $mail);

        $message->subject('The principals club Meeting');
        $message->to($principal_data->email);
        $message->attach($filename, array('mime' => "text/calendar"));
    });
    if(true){
        return response()->json([
            'message' =>'success',
         
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function test_ics_mail(){
    $to_name = "isuru";
    $to_email = "isuru050@gmail.com";
      $data = [];
    // $data = array(name’=>”Ogbonna Vitalis(sender_name)”, “body” => “A test mail”);

    $general = GeneralSetting::first();
    $config = $general->mail_config;
    // $receiver_name = explode('@', $request->email)[0];
    $subject = 'Testing ' . strtoupper($config->name) . ' Mail';
    $message = 'This is a test email, please ignore if you are not meant to be get this email.';

    // try {
    //     send_general_email($request->email, $subject, $message, $to_name);
    // } catch (\Exception $exp) {
    //     $notify[] = ['error', 'Invalid Credential'];
    //     // return back()->withNotify($notify);
    // }
    // \Mail::send('emails.email', $data, function($message) use ($to_name, $to_email)
    //  {
    //      $message->to($to_email, $to_name)->subject("Laravel Test Mail");

    //     });
    // $data = [];
    \Mail::send('emails.email', $data, function($message) use($data)
    {
        $filename = "assets/invite.ics";
        $meeting_duration = (3600 * 2); // 2 hours
        $meetingstamp = strtotime( '01-11-2022 11:11:11' . "UTC");
        $dtstart = gmdate('Ymd\THis\Z', strtotime('2022-02-12 01:00:00'));
        $dtend =  gmdate('Ymd\THis\Z', strtotime('2022-02-12 02:03:00'));
        $todaystamp = gmdate('Ymd\THis\Z');
        $uid = date('Ymd').'T'.date('His').'-'.rand().'@gmail.com';
        $description = 'test ics file';
        $location = "Telefone ou vídeo conferência";
        $titulo_invite = "Your meeting title test cc";
        $organizer = "CN=Organizer name:studylinkglobaledu@gmail.com";

        // ICS
        $mail[0]  = "BEGIN:VCALENDAR";
        $mail[1] = "PRODID:-//Google Inc//Google Calendar 70.9054//EN";
        $mail[2] = "VERSION:2.0";
        $mail[3] = "CALSCALE:GREGORIAN";
        $mail[4] = "METHOD:REQUEST";
        $mail[5] = "BEGIN:VEVENT";
        $mail[6] = "DTSTART;TZID=America/Sao_Paulo:" . $dtstart;
        $mail[7] = "DTEND;TZID=America/Sao_Paulo:" . $dtend;
        $mail[8] = "DTSTAMP;TZID=America/Sao_Paulo:" . $todaystamp;
        $mail[9] = "UID:" . $uid;
        $mail[10] = "ORGANIZER;" . $organizer;
        $mail[11] = "CREATED:" . $todaystamp;
        $mail[12] = "DESCRIPTION:" . $description;
        $mail[13] = "LAST-MODIFIED:" . $todaystamp;
        $mail[14] = "LOCATION:" . $location;
        $mail[15] = "SEQUENCE:0";
        $mail[16] = "STATUS:CONFIRMED";
        $mail[17] = "SUMMARY:" . $titulo_invite;
        $mail[18] = "TRANSP:OPAQUE";
        $mail[19] = "END:VEVENT";
        $mail[20] = "END:VCALENDAR";

        $mail = implode("\r\n", $mail);
        header("text/calendar");
        file_put_contents($filename, $mail);

        $message->subject('The principals club Meeting');
        $message->to('isuru1996323@gmail.com');
        $message->attach($filename, array('mime' => "text/calendar"));
    });
}
public function CloseChatMessage(Request $request)
{

    // return $request;
    $chatMessage = ChatMessagesModel::where('chat_messages.chat_code',$request->chat_code)->first();
    // $chatMessage->chat_hostory = $request->chat_hostory;
    // $chatMessage->save();

    $chatMessageReort = new ChatsReportModel();
    $chatMessageReort->chat_code =  $chatMessage->chat_code;
    $chatMessageReort->coach_code = $chatMessage->coach_code;
    $chatMessageReort->principal_code = $chatMessage->principal_code;
    $chatMessageReort->chat_hostory = $chatMessage->chat_hostory;
    $chatMessageReort->created_at = $chatMessage->created_at;
    $chatMessageReort->message_description = $chatMessage->description;
    $chatMessageReort->message_subject = $chatMessage->message_subject;
    $chatMessageReort->status = 0;
    $chatMessageReort->save();


   

    $noty_msg_body = "The Coach has closed your chat";
    $noty_msg_title = 'Coaching Question';
    $click_action = '';
    $msg_type = 'chat_new_message';
    $msg_id = $chatMessage->id;
    $sub_id = $chatMessage->chat_code;
    //dr reply to special msg

    $principal = Users::where('user_code',$chatMessage->principal_code)->first();

    PushNotificationCommon::sendNotification($principal->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
    $chatMessage->delete();
    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function UpdateAvailableTimePrincipal(Request $request)
{
    // return $request;
    $timeavailbale = PrincipalAvailableTimeModel::where('principal_available_time.user_code',$request->user_code)->where('principal_available_time.year_month',$request->yearMonth)->first();
    if( $timeavailbale){

        if($request->time!=null){
            $timeavailbale->available_time = $timeavailbale->available_time-$request->time;
            $timeavailbale->spend_time = $timeavailbale->spend_time+$request->time;
            $timeavailbale->save();

            return response()->json([
                'message' =>'success',
                'data' =>$timeavailbale,
            ]);
        }
        else{
            return response()->json([
                'message' =>'success',
                'data' =>$timeavailbale,
            ]);
        }
        

    }
    else{
        // $addtimeavailbale = new PrincipalAvailableTimeModel();
        // $addtimeavailbale->user_code = $request->user_code;
        // $addtimeavailbale->available_time = 120;
        // $addtimeavailbale->spend_time =0;
        // $addtimeavailbale->save();

        // return response()->json([
        //     'message' =>'success',
        //     'data' =>$addtimeavailbale,
        // ]);

    }



}

public function getClosedChatMessageCoach(Request $request)
{

    // return $request;
    $chatMessage = ChatsReportModel::select('chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->where('chat_messages_report.coach_code',$request->coach_code)
    ->leftJoin('users','users.user_code','chat_messages_report.principal_code')
    ->orderBy('updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function getClosedChatMessageCoacReport(Request $request)
{

    // return $request;
    $chatMessage = ChatsReportModel::select('chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->where('chat_messages_report.coach_code',$request->coach_code)
    ->whereBetween('chat_messages_report.created_at', [ $request->from,  $request->to])
    ->leftJoin('users','users.user_code','chat_messages_report.principal_code')
    ->orderBy('updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function getClosedChatMessagePrincipalPoolReport(Request $request)
{

    // return $request;
    $chatMessage = ChatsReportModel::select('chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->where('chat_messages_report.principal_code',$request->principal_code)
    ->leftJoin('users','users.user_code','chat_messages_report.coach_code')
    ->orderBy('updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function getClosedChatMessageCoachPoolReport(Request $request)
{

    // return $request;
    $chatMessage = ChatsReportModel::select('chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->where('chat_messages_report.coach_code',$request->coach_code)
    ->where('chat_messages_report.principal_code',$request->principal)
    ->leftJoin('users','users.user_code','chat_messages_report.principal_code')
    ->orderBy('updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function getCallReportPrincipalPool(Request $request)
{

    // return $request;
    $chatMessage = CallHostoryModel::where('scheduled_appointments.principal_code',$request->principal_code)
    
    ->select('call_history.*','users.first_name','users.last_name','users.profile_image','coach_writes_up.ratings','coach_writes_up.call_note')
    ->leftJoin('coach_writes_up','coach_writes_up.appointment_code','call_history.appointment_id')
    ->leftJoin('scheduled_appointments','scheduled_appointments.appointments_code','call_history.appointment_id')
    ->leftJoin('users','users.user_code','scheduled_appointments.coach_code')
    ->orderBy('updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function getCallReportCoachPool(Request $request)
{

    // return $request;
    $chatMessage = CallHostoryModel::where('scheduled_appointments.coach_code',$request->coach_code)
    ->where('scheduled_appointments.principal_code',$request->principal)
    ->select('call_history.*','users.first_name','users.last_name','users.profile_image','coach_feedback.ratings','coach_feedback.call_note')
    ->leftJoin('coach_feedback','coach_feedback.appointment_id','call_history.appointment_id')
    ->leftJoin('scheduled_appointments','scheduled_appointments.appointments_code','call_history.appointment_id')
    ->leftJoin('users','users.user_code','scheduled_appointments.principal_code')
    ->orderBy('updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}


public function getClosedChatMessagePrincipal(Request $request)
{

    // return $request;
    $chatMessage = ChatsReportModel::where('chat_messages_report.principal_code',$request->principal_code)
    
    ->select('chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->leftJoin('users','users.user_code','chat_messages_report.coach_code')
    ->orderBy('created_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function getClosedChatMessageHistoryPrincipal(Request $request)
{

    // return $request;
    $chatMessage = ChatsReportModel::where('chat_messages_report.chat_code',$request->chat_code)
    
    ->select('chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->leftJoin('users','users.user_code','chat_messages_report.coach_code')
    ->first();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function getClosedChatMessageHistoryCoach(Request $request)
{

    // return $request;
    $chatMessage = ChatsReportModel::where('chat_messages_report.chat_code',$request->chat_code)
    
    ->select('chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->leftJoin('users','users.user_code','chat_messages_report.principal_code')
    ->first();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function getChatListCoach(Request $request)
{

    // return $request;
    $chatMessage = ChatMessagesModel::where('chat_messages.coach_code',$request->coach_code)
    
    ->select('chat_messages.*','users.first_name','users.last_name','users.profile_image')
    ->join('users','users.user_code','chat_messages.principal_code')
    ->orderBy('updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
            
        ]);
    
    }

}

public function getChatListPrincipal(Request $request)
{

    // return $request;
    $chatMessage = ChatMessagesModel::where('chat_messages.principal_code',$request->principal_code)
    
    ->select('chat_messages.*','users.first_name','users.last_name','users.profile_image')
    ->join('users','users.user_code','chat_messages.principal_code')
    ->orderBy('updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
            
        ]);
    
    }

}
public function getCallReportCoach(Request $request)
{

    // return $request;
    $chatMessage = CallHostoryModel::where('scheduled_appointments.coach_code',$request->coach_code)
     ->whereBetween('call_history.created_at', [ $request->from,  $request->to])
    
    ->select('call_history.*','users.first_name','users.last_name','users.profile_image','scheduled_appointments.duration','scheduled_appointments.time_slot')
    ->leftJoin('scheduled_appointments','scheduled_appointments.appointments_code','call_history.appointment_id')
    ->leftJoin('users','users.user_code','scheduled_appointments.principal_code')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function getCallReportCountsCoach(Request $request)
{
    $duration_count;
    // return $request;
    $completed = CallHostoryModel::where('scheduled_appointments.coach_code',$request->coach_code)
     ->whereBetween('call_history.created_at', [ $request->from,  $request->to])
     ->leftJoin('scheduled_appointments','scheduled_appointments.appointments_code','call_history.appointment_id')
     ->count();

    $scheduled = ScheduledAppointments::where('scheduled_appointments.coach_code',$request->coach_code)
     ->whereBetween('scheduled_appointments.appt_date', [ $request->from,  $request->to])
     ->count();

     $cancelled = ScheduledAppointments::where('scheduled_appointments.coach_code',$request->coach_code)
     ->where('scheduled_appointments.status',3)
     ->whereBetween('scheduled_appointments.appt_date', [ $request->from,  $request->to])
     ->count();

     $users = ScheduledAppointments::where('scheduled_appointments.coach_code',$request->coach_code)
     ->whereBetween('scheduled_appointments.appt_date', [ $request->from,  $request->to])
     ->distinct()
     ->select('scheduled_appointments.principal_code')
     ->get();

     $duration_new = CallHostoryModel::where('scheduled_appointments.coach_code',$request->coach_code)
     ->whereBetween('call_history.created_at', [ $request->from,  $request->to])
     ->select('scheduled_appointments.duration')
     ->leftJoin('scheduled_appointments','scheduled_appointments.appointments_code','call_history.appointment_id')
     ->get();


    //  for ($i=1; $i <= sizeof($duration_new); $i++) {

    //     $duration_count=$duration_count+$duration_new[$i]['call_duration'];
    // }
 
        return response()->json([
            'message' =>'success',
            'completed' =>$completed,
            'scheduled' =>$scheduled,
            'cancelled' =>$cancelled,
            'duration_new' =>$duration_new,
            'users' =>sizeof($users),
        ]);
    
   

}

public function getChatReportCountsCoach(Request $request)
{
    $chatMessage_closed = ChatsReportModel::where('chat_messages_report.coach_code',$request->coach_code)
    ->whereBetween('updated_at', [ $request->from,  $request->to])
    ->orderBy('updated_at', 'DESC')
    ->count();

    $chatMessage_ongoing = ChatMessagesModel::where('chat_messages.coach_code',$request->coach_code)
    ->whereBetween('updated_at', [ $request->from,  $request->to])
    ->orderBy('updated_at', 'DESC')
    ->count();

    $principal_ongoing = ChatMessagesModel::where('chat_messages.coach_code',$request->coach_code)
    ->whereBetween('updated_at', [ $request->from,  $request->to])
    ->orderBy('updated_at', 'DESC')
    ->count();
 
    $principal_closed = ChatsReportModel::where('chat_messages_report.coach_code',$request->coach_code)
    ->whereBetween('updated_at', [ $request->from,  $request->to])
    ->orderBy('updated_at', 'DESC')
    ->count();

    $tot_principal_closed_count = ChatsReportModel::where('chat_messages_report.coach_code',$request->coach_code)
    ->whereBetween('updated_at', [ $request->from,  $request->to])
    ->orderBy('updated_at', 'DESC')
    ->select('chat_messages_report.principal_code')
    ->distinct()
    ->get();

    $tot_principal_ongoing_count = ChatMessagesModel::where('chat_messages.coach_code',$request->coach_code)
    ->whereBetween('updated_at', [ $request->from,  $request->to])
    ->select('chat_messages.principal_code')
    ->distinct()
    ->get();

        return response()->json([
            'message' =>'success',
            'closed_chat' =>$chatMessage_closed,
            'chatMessage_ongoing' =>$chatMessage_ongoing,
            'tot_principal_closed_count' =>sizeof($tot_principal_closed_count),
            'tot_principal_ongoing_count' =>sizeof($tot_principal_ongoing_count)
            
        ]);
    
   

}
public function getCoachWebinar(Request $request)
{
    $date = today()->format('Y-m-d');
    // return $request;
    $Webinar = WebinarModel::where('webinar.coach_code',$request->coach_code)
    ->where('webinar.date','>=',$date)
    ->select('webinar.*','users.first_name','users.last_name','users.profile_image')
    ->leftJoin('users','users.user_code','webinar.coach_code')
    ->get();

    if($Webinar){
        return response()->json([
            'message' =>'success',
            'data' =>$Webinar,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function getPrincipalWebinar(Request $request)
{
    $date = today()->format('Y-m-d');
    // return $request;
    // $Webinar = WebinarModel::where('webinar_users.prinicpal_code',$request->principal_code)->where('webinar_users.status','!=','2')
    // ->select('webinar.*','users.first_name','users.last_name','users.profile_image')
    // ->join('users','users.user_code','webinar.coach_code')
    // ->join('webinar_users','webinar.webinar_code','webinar_users.webinar_code')
    // ->get();
       $Webinar = WebinarModel::where('webinar.date','>=',$date)
    ->select('webinar.*','users.first_name','users.last_name','users.profile_image')
    ->join('users','users.user_code','webinar.coach_code')
    ->get();

    if($Webinar){
        return response()->json([
            'message' =>'success',
            'data' =>$Webinar,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function requestWebinaUser(Request $request)
{
    $available = WebinarUsersModel::where('webinar_users.prinicpal_code',$request->principal_code)->where('webinar_users.webinar_code',$request->webinar_code)->first();
    if($available){
        return response()->json([
            'message' =>'error',
            'data' =>'You alreadey Sent Request',
        ]);
    }
    else{
        $webinar = new WebinarUsersModel();
        $webinar->webinar_code = $request->webinar_code;
        $webinar->prinicpal_code = $request->principal_code;
        $webinar->status = 0;
        $webinar->save();
        if(true){
            return response()->json([
                'message' =>'success',
                'data' =>$webinar,
            ]);
        
        }
        else{
            return response()->json([
                'message' =>'error',
            ]);
        
        }
    }
  

}
public function webinarStatus(Request $request)
{
            $webinar = WebinarModel::where('webinar.webinar_code',$request->webinar_code)->first();
        $webinar->status = $request->status;
        $webinar->save();
        
        if($request->status==2){
           

                $noty_msg_body = "Webinar, $webinar->title has been started!";
                $noty_msg_title = 'Webinar Started';
                $click_action = '';
                $msg_type = 'webinar_reminder';
                $msg_id = $webinar->id;
                $sub_id = 0;

                // notification to coach:
               // PushNotificationCommon::sendNotification($webinar->coach->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);

                // get webinar users 
                $wbUsers = Users::where('user_type','principal')->where('status',1)->get();

                    foreach ($wbUsers as $key => $wbUser) {
                    // notification to users/principals: 
                    $msg_id = $wbUser->id; 
                    PushNotificationCommon::sendNotification($wbUser->id, $noty_msg_body, $noty_msg_title, $click_action, $msg_type, $msg_id, $sub_id);
                    }
            
        }

        if(true){
            return response()->json([
                'message' =>'success',
                'data' =>$webinar,
            ]);

        }
        else{
            return response()->json([
                'message' =>'error',
            ]);

}
  

}

public function webinarCode(Request $request)
{
            $webinar = WebinarModel::where('webinar.webinar_code',$request->webinar_code)->first();
        

        if(true){
            return response()->json([
                'message' =>'success',
                'data' =>$webinar,
            ]);

        }
        else{
            return response()->json([
                'message' =>'error',
            ]);

}
  

}
public function deletAppointmentFromList(Request $request)
{
            $appointment = ScheduledAppointments::where('scheduled_appointments.appointments_code',$request->appointments_code)->first();
        $appointment->delete = 1;
        $appointment->save();
        

        if(true){
            return response()->json([
                'message' =>'success',
                'data' =>$appointment,
            ]);

        }
        else{
            return response()->json([
                'message' =>'error',
            ]);

}
  

}
////////Technical Chat//////////////////
public function getTechnicalChatListPrincipal(Request $request)
{

    // return $request;
    $chatMessage = TechnicalChatMessageModel::where('technical_chat_messages.principal_code',$request->principal_code)
    
    ->select('technical_chat_messages.*','users.first_name','users.last_name','users.profile_image')
    ->join('users','users.user_code','technical_chat_messages.principal_code')
    ->orderBy('technical_chat_messages.updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
            
        ]);
    
    }

}

public function getPrincipalTechnicalChatMessage(Request $request)
{


    if($request->is_initiate=='false'){
        $chats = TechnicalChatMessageModel::where('technical_chat_messages.chat_code',$request->chat_code)
        ->first();

        return response()->json([
            'message' =>'successsss',
            'data' => $chats
        ]);
    }
    else{
        $chatCode= Uuid::generate(4);

        $chatMessage = new TechnicalChatMessageModel();
        $chatMessage->chat_code =  $chatCode;
        // $chatMessage->coach_code = $request->coach_code;
        $chatMessage->principal_code = $request->principal_code;
        $chatMessage->description  = $request->description;
        // $chatMessage->chat_history  = $request->history;
        $chatMessage->subject  = $request->message_subject;
        $chatMessage->status = 1;
        $chatMessage->save();


        $chatMessagess = TechnicalChatMessageModel::where('technical_chat_messages.chat_code',$chatCode)->first();
        if($chatMessage){
            return response()->json([
                'message' =>'success',
                'data' => $chatMessagess
            ]);
        
        }
        else{
            return response()->json([
                'message' =>'unsuccess',
            ]);
        
        }
    }


}
public function UpdateTechnicalChatMessage(Request $request)
{
    // return $request;
    $chatMessage = TechnicalChatMessageModel::where('technical_chat_messages.chat_code',$request->chat_code)->first();
    $chatMessage->chat_history = $request->chat_hostory;
    $chatMessage->last_reply = $request->last_reply;
    $chatMessage->technical_replied = $request->tech_replied;
    $chatMessage->principal_replied = $request->principal_replied;
    $chatMessage->save();
    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function getTechnicalClosedChatMessagePrincipal(Request $request)
{

    // return $request;
    $chatMessage = TechnicalChatReportModel::where('technical_chat_messages_report.principal_code',$request->principal_code)
    
    ->select('technical_chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->leftJoin('users','users.user_code','technical_chat_messages_report.principal_code')
    ->orderBy('created_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function getTechnicalClosedChatMessageHistoryPrincipal(Request $request)
{

    // return $request;
    $chatMessage = TechnicalChatReportModel::where('technical_chat_messages_report.chat_code',$request->chat_code)
    
    ->select('technical_chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->leftJoin('users','users.user_code','technical_chat_messages_report.principal_code')
    ->first();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}


////////Other Chat//////////////////
public function getOtherChatListPrincipal(Request $request)
{

    // return $request;
    $chatMessage = OtherChatMessageModel::where('other_chat_messages.principal_code',$request->principal_code)
    
    ->select('other_chat_messages.*','users.first_name','users.last_name','users.profile_image')
    ->join('users','users.user_code','other_chat_messages.principal_code')
    ->orderBy('other_chat_messages.updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
            
        ]);
    
    }

}

public function getPrincipalOtherChatMessage(Request $request)
{


    if($request->is_initiate=='false'){
        $chats = OtherChatMessageModel::where('other_chat_messages.chat_code',$request->chat_code)
        ->first();

        return response()->json([
            'message' =>'successsss',
            'data' => $chats
        ]);
    }
    else{
        $chatCode= Uuid::generate(4);

        $chatMessage = new OtherChatMessageModel();
        $chatMessage->chat_code =  $chatCode;
        // $chatMessage->coach_code = $request->coach_code;
        $chatMessage->principal_code = $request->principal_code;
        $chatMessage->description  = $request->description;
        // $chatMessage->chat_history  = $request->history;
        $chatMessage->subject  = $request->message_subject;
        $chatMessage->status = 1;
        $chatMessage->save();


        $chatMessagess = OtherChatMessageModel::where('other_chat_messages.chat_code',$chatCode)->first();
        if($chatMessage){
            return response()->json([
                'message' =>'success',
                'data' => $chatMessagess
            ]);
        
        }
        else{
            return response()->json([
                'message' =>'unsuccess',
            ]);
        
        }
    }


}
public function UpdateOtherChatMessage(Request $request)
{
    // return $request;
    $chatMessage = OtherChatMessageModel::where('other_chat_messages.chat_code',$request->chat_code)->first();
    $chatMessage->chat_history = $request->chat_hostory;
    $chatMessage->last_reply = $request->last_reply;
    $chatMessage->admin_replied = $request->admin_replied;
    $chatMessage->principal_replied = $request->principal_replied;
    $chatMessage->save();
    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function getOtherClosedChatMessagePrincipal(Request $request)
{

    // return $request;
    $chatMessage = OtherChatReportModel::where('other_chat_messages_report.principal_code',$request->principal_code)
    
    ->select('other_chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->leftJoin('users','users.user_code','other_chat_messages_report.principal_code')
    ->orderBy('created_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function getOtherClosedChatMessageHistoryPrincipal(Request $request)
{

    // return $request;
    $chatMessage = OtherChatReportModel::where('other_chat_messages_report.chat_code',$request->chat_code)
    
    ->select('other_chat_messages_report.*','users.first_name','users.last_name','users.profile_image')
    ->leftJoin('users','users.user_code','other_chat_messages_report.principal_code')
    ->first();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

////////Feedback Chat//////////////////
public function getFeedbackChatListPrincipal(Request $request)
{

    // return $request;
    $chatMessage = FeedbackChatMessageModel::where('feedback_chat_messages.principal_code',$request->principal_code)
    
    ->select('feedback_chat_messages.*','users.first_name','users.last_name','users.profile_image')
    ->join('users','users.user_code','feedback_chat_messages.principal_code')
    ->orderBy('feedback_chat_messages.updated_at', 'DESC')
    ->get();

    if($chatMessage){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
            
        ]);
    
    }

}

public function getPrincipalFeedbackChatMessage(Request $request)
{


    if($request->is_initiate=='false'){
        $chats = FeedbackChatMessageModel::where('feedback_chat_messages.chat_code',$request->chat_code)
        ->first();

        return response()->json([
            'message' =>'successsss',
            'data' => $chats
        ]);
    }
    else{
        $chatCode= Uuid::generate(4);

        $chatMessage = new FeedbackChatMessageModel();
        $chatMessage->chat_code =  $chatCode;
        // $chatMessage->coach_code = $request->coach_code;
        $chatMessage->principal_code = $request->principal_code;
        $chatMessage->description  = $request->description;
        // $chatMessage->chat_history  = $request->history;
        $chatMessage->subject  = $request->message_subject;
        $chatMessage->status = 1;
        $chatMessage->save();


        $chatMessagess = FeedbackChatMessageModel::where('feedback_chat_messages.chat_code',$chatCode)->first();
        if($chatMessage){
            return response()->json([
                'message' =>'success',
                'data' => $chatMessagess
            ]);
        
        }
        else{
            return response()->json([
                'message' =>'unsuccess',
            ]);
        
        }
    }


}
public function UpdateFeedbackChatMessage(Request $request)
{
    // return $request;
    $chatMessage = FeedbackChatMessageModel::where('feedback_chat_messages.chat_code',$request->chat_code)->first();
    $chatMessage->chat_history = $request->chat_hostory;
    $chatMessage->save();
    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$chatMessage,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function UpdateRatings(Request $request)
{
    // return $request;

    $feedback =  $appointment = CoachFeedback::where('appointment_id',$request->appointment_id)->first();

    if(true){


        if($feedback){
            $feedback->ratings = $request->ratings;
            $feedback->call_note = $request->call_note;
            $feedback->save();
        }
        else{
            $feedbacks =  new CoachFeedback();
            $feedbacks->appointment_id = $request->appointment_id;
            $feedbacks->ratings = $request->ratings;
            $feedbacks->call_note = $request->call_note;
            $feedbacks->save();
        }
        return response()->json([
            'message' =>'success',
            'data' =>$feedback,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}
public function UpdateWriteUps(Request $request)
{
    // return $request;
    $feedback =  new CoachWriteUp();
    $feedback->appointment_code = $request->appointment_id;
    $feedback->ratings = $request->ratings;
    $feedback->call_note = $request->call_note;
    $feedback->save();
    if(true){
        return response()->json([
            'message' =>'success',
            'data' =>$feedback,
        ]);
    
    }
    else{
        return response()->json([
            'message' =>'error',
        ]);
    
    }

}

public function updatePrincipalTimesByApi()
{
    $principals = Users::where('user_type', 'principal')
    ->get();
   
                foreach ($principals as $key => $principal) {
                // \Log::info("schedule >>>>> ");
                // \Log::info($schedule);

                for ($i=3; $i <= 12; $i++) {

                    $addtimeavailbale =new PrincipalAvailableTimeModel();
                    $addtimeavailbale->user_code = $principal->user_code;
                    $addtimeavailbale->available_time = 120;
                    $addtimeavailbale->spend_time =0;
                    if($i<10){
                        $addtimeavailbale->year_month ='2022-0'.$i;
                    }
                    else{
                        $addtimeavailbale->year_month ='2022-'.$i;
                    }
                    
                    $addtimeavailbale->save();
                }
                   
                }


    $notify[] = ['success', 'Authors detail has been updated'];
    return redirect()->back()->withNotify($notify);
}

public function getCoachPrevoiusDateScheduled(Request $request)
{


   $alreadyBooked=false;
// for($i = 0; $i < sizeof($request->slot); $i++){
//     $users =  $appointment = ScheduledAppointments::where('scheduled_appointments.coach_code',$request->coach_code)->Where('appt_date','=',$request->date)
//     ->where('time_slot','=',$request->slot[$i])
//     ->first();
//     if($users){
//         $alreadyBooked=true;
        
//     }
    
// }
    $users =  $appointment = CoachAvailabilityModel::where('coach_availability.coach_code',$request->coach_code)
    ->where('coach_availability_detail.date',$request->date)
    ->join('coach_availability_detail','coach_availability_detail.avail_code','coach_availability.avail_code')
    ->first();

    if($users){
        $alreadyBooked=true;
        
    }
    return response()->json([
        'message' =>$alreadyBooked?'unsuccess':'success',
    ]);
    
  
  

}


}
