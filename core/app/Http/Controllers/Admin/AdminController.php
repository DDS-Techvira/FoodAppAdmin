<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Assistant;
use App\Deposit;
use App\Rules\FileTypeValidate;
use App\Doctor;
use App\DoctorLogin;
use App\Gateway;
use App\Admin;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Staff;
use App\Users;
use App\Sector;
use App\Location;
use App\ScheduledAppointments;

class AdminController extends Controller
{

    public function dashboard()
    {
        $page_title = 'Dashboard';

        //Info
        $widget['total_doctors'] = Users::where('user_type','coach')->count();
        $widget['total_assistants'] = Users::where('user_type','principal')->count();
        $widget['total_staff'] = ScheduledAppointments::where('status', 4)->count();
        $widget['new_appointments'] = ScheduledAppointments::select('scheduled_appointments.*')
                    ->leftJoin('call_history', 'call_history.appointment_id', 'scheduled_appointments.appointments_code')
                    ->leftJoin('coach_feedback', 'coach_feedback.appointment_id', 'scheduled_appointments.appointments_code')
                    ->leftJoin('coach_writes_up', 'coach_writes_up.appointment_code', 'scheduled_appointments.appointments_code')
                    // ->join('users as coach','coach.user_code','scheduled_appointments.coach_code') 
                    // ->join('users as principal','principal.user_code','scheduled_appointments.principal_code')
                    ->count();
     
        $appointment_chart = Appointment::where('try',1)->whereYear('created_at', '=', date('Y'))->orderBy('created_at')->get()->groupBy(function ($d) {
            return $d->created_at->format('F');
        });

        $appointment_all = [];
        $month_appointment = [];
        foreach ($appointment_chart as $key => $value) {
            $appointment_all[] = count($value);
            $month_appointment[] = $key;
        }

        // Monthly Online Payment
        $report['months'] = collect([]);
        $report['deposit_month_amount'] = collect([]);

        // $depositsMonth = Deposit::whereYear('created_at', '>=', Carbon::now()->subYear())
        //     ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as depositAmount")
        //     ->selectRaw("DATE_FORMAT(created_at,'%M') as months")
        //     ->orderBy('created_at')
        //     ->groupBy(DB::Raw("MONTH(created_at)"))->get();

        // $depositsMonth->map(function ($aaa) use ($report) {
        //     $report['months']->push($aaa->months);
        //     $report['deposit_month_amount']->push(getAmount($aaa->depositAmount));
        // });

        $doctor_login_data = 1;

        $chart['doctor_browser_counter'] = 1;
        $chart['doctor_os_counter'] = 1;
        $chart['doctor_country_counter'] = 1;

        // $payment['payment_method'] = Gateway::count();
        // $payment['total_deposit_amount'] = Deposit::where('status',1)->sum('amount');
        // $payment['total_deposit_charge'] = Deposit::where('status',1)->sum('charge');
        // $payment['total_deposit_pending'] = Deposit::where('status',2)->count();

        $latestDoctors = '';
        $empty_message = 'No doctor found';
        return view('admin.dashboard', compact('page_title', 'widget', 'report', 'chart','latestDoctors','empty_message','appointment_all','month_appointment'));
    }


    public function profile()
    {
        $page_title = 'Profile';
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('page_title', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable'
        ]);

        $user = Auth::guard('admin')->user();

        if($request->image) {
            try{
                $location = imagePath()['admin']['path'];
                $user->image = uploadImageData($request->image, $location) ?? '';
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('admin.profile')->withNotify($notify);
    }


    public function password()
    {
        $page_title = 'Password Setting';
        $admin = Auth::guard('admin')->user();
        return view('admin.password', compact('page_title', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = Auth::guard('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password Do not match !!'];
            return back()->withErrors(['Invalid old password.']);
        }

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        $notify[] = ['success', 'Password Changed Successfully.'];
        
        return redirect()->route('admin.password')->withNotify($notify);
    }

    ////////////////////////////ADMINS///////////////////////////
    public function AllAdmins()
    {
        $page_title = 'Manage Admins';
        $empty_message = 'No Admins found';
        $authors = Admin::latest()->paginate(getPaginate());
        return view('admin.admins.list', compact('page_title', 'empty_message', 'authors'));
    }

    public function newAdmins(){
        $page_title = 'Add New Admins';
        $sectors = Http::get('https://gist.githubusercontent.com/mshafrir/2646763/raw/8b0dbb93521f5d6889502305335104218454c2bf/states_titlecase.json');
        return view('admin.admins.new', compact('page_title','sectors'));
    }

    public function storeAdmins(Request $request){
        $request->validate([
            'image' => ['required'],
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'mobile' => 'required|string|max:191',
            'password' => 'required|string|min:6|confirmed',
            'about' => 'required',
        ]);

        $admin_image = '';
        if($request->image) {
            try{
                $location = imagePath()['admin']['path'];
                $admin_image = uploadImageData($request->image, $location);
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $admin = new Admin();
        $admin->image = $admin_image;
        $admin->name =  $request->name;
        $admin->username =  $request->email;
        $admin->email =  $request->email;
        $admin->mobile_no =  $request->mobile;
        $admin->bio =$request->about;
        $admin->address =$request->address;
        $admin->password =  Hash::make($request->password);
        $admin->save();

        $notify[] = ['success', 'Admin details has been added'];
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $page_title = 'Admin Detail';
        $admin = Admin::findOrFail($id);
        $sectors = Sector::latest()->get();
        $sectors = Http::get('https://gist.githubusercontent.com/mshafrir/2646763/raw/8b0dbb93521f5d6889502305335104218454c2bf/states_titlecase.json');

        return view('admin.admins.detail', compact('page_title', 'admin','sectors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,id,'.$id,
            'mobile' => 'required|string|max:191',
            'about' => 'required',
        ]);
        // dd($request->all());
        $admin =Admin::findOrFail($id);
        if ($request->email != $admin->email && Admin::whereEmail($request->email)->whereId('!=', $admin->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }

        if($request->image) {
            try{
                $location = imagePath()['admin']['path'];
                $admin->image = uploadImageData($request->image, $location) ?? '';
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }
        
        $admin->name =  $request->name;
        $admin->email =  $request->email;
        $admin->mobile_no =  $request->mobile;
        $admin->bio =$request->about;
        $admin->status = $request->status=='on'?1:0;
        $admin->address =$request->address;
        $admin->save();


        $notify[] = ['success', 'Authors detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function passwordReset(Request $request, $id)
    {
        $request->validate([
                'password' => 'required|string|min:6|confirmed'
            ]);

        $admin = Admin::findOrFail($id);

        $admin->password = bcrypt($request->password);
        if($admin->save()) {
            $notify[] = ['success', 'Admin`s password reset successfuly'];
            return redirect()->back()->withNotify($notify);
        }

        $notify[] = ['success', 'Admin`s password reset failed'];
        return redirect()->back()->withNotify($notify);
    }

}
