<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Staff;
use App\StaffLogin;
use App\Http\Controllers\Controller;
use App\Patient;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;

class ManagePatientController extends Controller
{
    public function allPatient(){
        $page_title = 'All Patients';
        $empty_message = 'No Patients found';
        $patient = Patient::latest()->paginate(getPaginate());
        return view('admin.patient.list', compact('page_title', 'empty_message', 'patient'));
    }

    public function activeStaff()
    {
        $page_title = 'Active Patients';
        $empty_message = 'No active Patients found';
        $patient = Patient::active()->latest()->paginate(getPaginate());
        return view('admin.patient.list', compact('page_title', 'empty_message', 'patient'));
    }

    public function bannedStaff()
    {
        $page_title = 'Banned Patients';
        $empty_message = 'No banned user found';
        $patient = Patient::banned()->latest()->paginate(getPaginate());
        return view('admin.patient.list', compact('page_title', 'empty_message', 'patient'));
    }

    public function emailUnverifiedPatient()
    {
        $page_title = 'Email Unverified Patients';
        $empty_message = 'No email unverified user found';
        $patient = Patient::emailUnverified()->latest()->paginate(getPaginate());
        return view('admin.patient.list', compact('page_title', 'empty_message', 'patient'));
    }
    public function emailVerifiedPatient()
    {
        $page_title = 'Email Verified Patients';
        $empty_message = 'No email verified user found';
        $patient = Patient::emailVerified()->latest()->paginate(getPaginate());
        return view('admin.patient.list', compact('page_title', 'empty_message', 'patient'));
    }


    public function smsUnverifiedPatient()
    {
        $page_title = 'SMS Unverified Patients';
        $empty_message = 'No sms unverified user found';
        $patient = Patient::smsUnverified()->latest()->paginate(getPaginate());
        return view('admin.patient.list', compact('page_title', 'empty_message', 'patient'));
    }
    public function smsVerifiedPatient()
    {
        $page_title = 'SMS Verified StafPatientsf';
        $empty_message = 'No sms verified user found';
        $patient = Patient::smsVerified()->latest()->paginate(getPaginate());
        return view('admin.patient.list', compact('page_title', 'empty_message', 'patient'));
    }

    public function newPatient(){
        $page_title = 'Add New Patients';
        return view('admin.patient.new', compact('page_title'));
    }

    public function storePatient(Request $request){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'email' => 'required|string|email|max:190|unique:patients',
            'mobile' => 'required|string|max:190|unique:patients',
            'password' => 'required|string|min:6|confirmed',
           // 'username' => 'required|alpha_num|unique:patient|min:6',
            'address' => 'required|string|max:190',
        ]);

        $staff_image = '';
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['staff']['path'];
                $size = imagePath()['staff']['size'];

                $staff_image = uploadImage($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }


        $patient = Patient::create([
            'image' => $staff_image,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'username' => $request->email,
            'address' => $request->address,
        ]);

        notify($patient, 'STAFF_CREDENTIALS', [
            'username' => $patient->username,
            'password' => $request->password,
        ]);

        $notify[] = ['success', 'Patient details has been added'];
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $page_title = 'Patients Detail';

        $staff = Patient::findOrFail($id);

        $new_appointment = Appointment::where('staff',$staff->id)->where('try',1)->where('d_status',0)->where('is_complete',0)->whereHas('relationStaff', function ($query) {
            $query->where('status',1);
        })->count();

        $appointment_done = Appointment::where('staff',$staff->id)->where('try',1)->where('is_complete',1)->where('p_status',1)->where('d_status',0)->latest()->whereHas('relationStaff', function ($query) {
            $query->where('status',1);
       })->count();

        $total_appointment = Appointment::where('staff',$staff->id)->where('try',1)->where('d_status',0)->latest()->where('is_complete',0)->whereHas('relationStaff', function ($query) {
            $query->where('status',1);
       })->count();
        return view('admin.patient.detail', compact('page_title', 'staff','new_appointment','appointment_done','total_appointment'));
    }

    public function update(Request $request, $id)
    {
        $staff = Patient::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:190',
            'email' => 'required|email|max:190|unique:patient,email,' . $staff->id,
            'mobile' => 'required|string|max:190|unique:patient,mobile,' . $staff->id,
            'address' => 'required|string|max:190',
        ]);

        if ($request->email != $staff->email && Patient::whereEmail($request->email)->whereId('!=', $staff->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }
        if ($request->mobile != $staff->mobile && Patient::where('mobile', $request->mobile)->whereId('!=', $staff->id)->count() > 0) {
            $notify[] = ['error', 'Mobile number already exists.'];
            return back()->withNotify($notify);
        }

        $staff->update([
            'mobile' => $request->mobile,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status ? 1 : 0,
            'ev' => $request->ev ? 1 : 0,
            'sv' => $request->sv ? 1 : 0,
            'tv' => $request->tv ? 1 : 0,
            'ts' => $request->ts ? 1 : 0,
        ]);

        $notify[] = ['success', 'Patient detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $staff = Staff::where(function ($staff) use ($search) {
            $staff->where('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%");
        });
        $page_title = '';
        switch ($scope) {
            case 'active':
                $page_title .= 'Active ';
                $staff = $staff->where('status', 1);
                break;
            case 'banned':
                $page_title .= 'Banned';
                $staff = $staff->where('status', 0);
                break;
            case 'emailUnverified':
                $page_title .= 'Email Unerified ';
                $staff = $staff->where('ev', 0);
                break;
            case 'smsUnverified':
                $page_title .= 'SMS Unverified ';
                $staff = $staff->where('sv', 0);
                break;
        }
        $staff = $staff->paginate(getPaginate());
        $page_title .= 'Staff Search - ' . $search;
        $empty_message = 'No search result found';
        return view('admin.staff.list', compact('page_title', 'search', 'scope', 'empty_message', 'staff'));
    }

    public function staffLoginHistory($id)
    {
        $staff = Staff::findOrFail($id);
        $page_title = 'Staff Login History - ' . $staff->username;
        $empty_message = 'No staff login found.';
        $login_logs = $staff->login_logs()->latest()->paginate(getPaginate());
        return view('admin.staff.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function loginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Staff Login History Search - ' . $search;
            $empty_message = 'No search result found.';
            $login_logs = StaffLogin::whereHas('staff', function ($query) use ($search) {
                $query->where('username', $search);
            })->latest()->paginate(getPaginate());
            return view('admin.staff.logins', compact('page_title', 'empty_message', 'search', 'login_logs'));
        }
        $page_title = 'Staff Login History';
        $empty_message = 'No staff login found.';
        $login_logs = StaffLogin::latest()->paginate(getPaginate());
        return view('admin.staff.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        $page_title = 'Login By - ' . $ip;
        $login_logs = StaffLogin::where('staff_ip',$ip)->latest()->paginate(getPaginate());
        $empty_message = 'No staff login found.';
        return view('admin.staff.logins', compact('page_title', 'empty_message', 'login_logs'));

    }

    public function showEmailSingleForm($id)
    {
        $staff = Staff::findOrFail($id);
        $page_title = 'Send Email To: ' . $staff->username;
        return view('admin.staff.email_single', compact('page_title', 'staff'));
    }

    public function sendEmailSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        $staff = Staff::findOrFail($id);
        send_general_email($staff->email, $request->subject, $request->message, $staff->username);
        $notify[] = ['success', $staff->username . ' will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function showEmailAllForm()
    {
        $page_title = 'Send Email To All Staff';
        return view('admin.staff.email_all', compact('page_title'));
    }

    public function sendEmailAll(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        foreach (Staff::where('status', 1)->cursor() as $staff) {
            send_general_email($staff->email, $request->subject, $request->message, $staff->username);
        }

        $notify[] = ['success', 'All Staff will receive an email shortly.'];
        return back()->withNotify($notify);
    }
}
