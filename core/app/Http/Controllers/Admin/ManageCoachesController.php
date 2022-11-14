<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Http;
use App\Appointment;
use App\Assistant;
use App\Deposit;
use App\Disease;
use App\Doctor;
use App\DoctorLogin;
use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Rules\CoachAvailabilityRecurringScheduleValidate;
use App\Rules\CoachAvailabilityDateRangeOverlap;
use App\CoachAvailabilityModel;
use App\CoachAvailableDetail;

use App\Sector;
use App\Users;
use App\DrArticles;
use App\DrYotube;
use Carbon\Carbon;
use App\Gallery;
use Illuminate\Support\Facades\Hash;
use Uuid;
use Mail;
class ManageCoachesController extends Controller
{
    public function sectors(){
        $page_title = 'Manage Sector';
        $empty_message = 'No sector found';
        $sectors = Sector::latest()->paginate(getPaginate());
        return view('admin.doctors.sector', compact('page_title', 'empty_message','sectors'));
    }

    public function storeSectors(Request $request){
        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $subject_image = '';
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['sector']['path'];
                $size = imagePath()['sector']['size'];

                $subject_image = uploadImage($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        Sector::create([
            'image' => $subject_image,
            'name' => $request->name,
            'details' => $request->details,
        ]);

        $notify[] = ['success', 'Sector details has been added'];
        return back()->withNotify($notify);
    }

    public function updateSectors(Request $request,$id){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $sector = Sector::findOrFail($id);

        $subject_image = $sector->image;
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['sector']['path'];
                $size = imagePath()['sector']['size'];
                $old = $sector->image;
                $subject_image = uploadImage($request->image, $location , $size, $old);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $sector->update([
            'image' => $subject_image,
            'name' => $request->name,
            'details' => $request->details,
        ]);

        $notify[] = ['success', 'Sector details has been Updated'];
        return back()->withNotify($notify);
    }

    /////Disease
    public function diseases(){
        $page_title = 'Manage Disease';
        $empty_message = 'No diseas found';
        $sectors = Disease::latest()->paginate(getPaginate());
        return view('admin.doctors.disease', compact('page_title', 'empty_message','sectors'));
    }

    public function storeDiseases(Request $request){
        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $subject_image = '';
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['disease']['path'];
                $size = imagePath()['disease']['size'];

                $subject_image = uploadImage($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        Disease::create([
            'image' => $subject_image,
            'name' => $request->name,
            'details' => $request->details,
        ]);

        $notify[] = ['success', 'Disease details has been added'];
        return back()->withNotify($notify);
    }

    public function updateDiseases(Request $request,$id){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $sector = Disease::findOrFail($id);

        $subject_image = $sector->image;
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['disease']['path'];
                $size = imagePath()['disease']['size'];
                $old = $sector->image;
                $subject_image = uploadImage($request->image, $location , $size, $old);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $sector->update([
            'image' => $subject_image,
            'name' => $request->name,
            'details' => $request->details,
        ]);

        $notify[] = ['success', 'Disease details has been Updated'];
        return back()->withNotify($notify);
    }

    /////Gallery
    public function gallery(){
        $page_title = 'Manage Gallery Images';
        $empty_message = 'No images found';
        $sectors = Gallery::latest()->paginate(getPaginate());
        return view('admin.doctors.gallery', compact('page_title', 'empty_message','sectors'));
    }
    public function galleryRemove($id){

        $gallery = Gallery::where('id', $id)->findOrFail($id);
        $gallery->delete();

        $notify[] = ['success', 'Image successfuly deleted'];
        return back()->withNotify($notify);

    }
    public function storegallery(Request $request){
        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            // 'name' => 'required|string|max:190',
            // 'details' => 'required|string|max:190'
        ]);

        $subject_image = '';
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['gallery']['path'];
                $size = imagePath()['gallery']['size'];

                $subject_image = uploadImage($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        // Gallery::create([
        //     'image' => $subject_image,
        //     'status' => 1,
        //     // 'details' => $request->details,
        // ]);
        $article = new Gallery();
        $article->image = $subject_image;
        $article->status =  1;
        $article->save();

        $notify[] = ['success', 'Gallery details has been added'];
        return back()->withNotify($notify);
    }

    public function updategallery(Request $request,$id){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $sector = Disease::findOrFail($id);

        $subject_image = $sector->image;
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['disease']['path'];
                $size = imagePath()['disease']['size'];
                $old = $sector->image;
                $subject_image = uploadImage($request->image, $location , $size, $old);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $sector->update([
            'image' => $subject_image,
            'name' => $request->name,
            'details' => $request->details,
        ]);

        $notify[] = ['success', 'Disease details has been Updated'];
        return back()->withNotify($notify);
    }


    public function locations(){
        $page_title = 'Manage Location';
        $empty_message = 'No location found';
        $locations = Location::latest()->paginate(getPaginate());
        return view('admin.doctors.location', compact('page_title', 'empty_message','locations'));
    }

    public function storeLocations(Request $request){
        $request->validate([
            'name' => 'required|string|max:190'
        ]);

        Location::create([
            'name' => $request->name,
        ]);

        $notify[] = ['success', 'Location details has been added'];
        return back()->withNotify($notify);
    }

    public function updateLocations(Request $request,$id){

        $request->validate([
            'name' => 'required|string|max:190'
        ]);

        $sector = Location::findOrFail($id);

        $sector->update([
            'name' => $request->name,
        ]);

        $notify[] = ['success', 'Location details has been Updated'];
        return back()->withNotify($notify);
    }
///////Articles///////////////
public function articlesAll(){
    $sector = Sector::all();
    $doctors = Doctor::all();


    $page_title = 'All Articles Details';
    $education_details = DrArticles::select('doctor_articles.*','doctors.name')
    // ->where('doctor_id', Auth::guard('doctor')->user()->id)
    ->join('doctors', 'doctors.id', '=', 'doctor_articles.doctor_id')
    ->get();
    return view('admin.doctors.articles',compact('page_title','education_details','sector','doctors'));
}
public function uploadArticleImage(Request $request)
{
    $image = $request->file('file');
    $imageName = $image->getClientOriginalName();
    $done=$image->move('assets/articles', $imageName);
    return response()->json(['successss' => $imageName]);

    // try{

    //     $location = imagePath()['appointment']['path'];
    //     $size = imagePath()['appointment']['size'];
    //     $image->move($path, $filename);
    //   $staff_image = uploadImage($request->file('file'), $location , $size);

    // }catch(\Exception $exp) {
    //     return 'error Could not upload the image.';
    // }
}
public function articlesStore(Request $request){

    $this->validate($request, [
        'institution' => 'required|max:190',
        'discipline' => 'required|max:190',
        'period' => 'required|max:190',
    ]);

    // DrArticles::create([
    //     'doctor_id' => Auth::guard('doctor')->user()->id,
    //     'institution' => $request->institution,
    //     'discipline' => $request->discipline,
    //     'period' => $request->period,
    // ]);

    $notify[] = ['success', 'Education details has been added'];
    return back()->withNotify($notify);

}

public function articlesUpdate(Request $request, $id){

    // $article = new DrArticles();
    // $article->doctor_id = $request->doctor_id;
    // $article->article_title =  $request->title;
    // $article->article_description =  $request->description;
    // $article->article_image = $request->selectedDocument[0];
    // $article->category =  $request->category;
    // $article->save();
// return $request->title;
    $article = DrArticles::findOrFail($id);
    $subject_image = $article->article_image;
    if($request->hasFile('image')) {
        try{

            $location = imagePath()['articles']['path'];
            $size = imagePath()['articles']['size'];
            $old = $article->article_image;
            $subject_image = uploadImage($request->image, $location , $size, $old);

        }catch(\Exception $exp) {
            return back()->withNotify(['error', 'Could not upload the image.']);
        }
    }
    // $article->update([
    //     // 'doctor_id' => $request->title,
    //     'article_title' => $request->title,
    //     'article_description' => $request->details,
    //     'article_image' => $subject_image,
    //     // 'category' => $request->category,
    // ]);

    $article->article_title = $request->title;
    $article->article_description =   $request->details;
    $article->doctor_id =$request->doctor_id;
    $article->category  =$request->category;
    $article->article_image = $subject_image;
    $article->save();

    $notify[] = ['success', 'Article details has been updated'];
    return back()->withNotify($notify);

}

public function articlesRemove($id){

    $education_details = DrArticles::findOrFail($id);
    $education_details->delete();

    $notify[] = ['success', 'Article successfuly deleted'];
    return back()->withNotify($notify);

}
public function articleStore(Request $request){

    // $this->validate($request, [
    //     'title' => 'required|max:190',
    //     'discipline' => 'required|max:190',
    //     'period' => 'required|max:190',
    // ]);

    // DrArticles::create([
    //     'doctor_id' => 1,
    //     'article_title' => $request->title,
    //     'article_description' => $request->description,
    //     'article_image' => $request->selectedDocument,
    //     'category' => $request->category,
    // ]);
    $article = new DrArticles();
    $article->doctor_id = $request->doctor_id;
    $article->article_title =  $request->title;
    $article->article_description =  $request->description;
    $article->article_image = $request->selectedDocument[0];
    $article->category =  $request->category;
    $article->save();
    $notify[] = ['success', 'Article has been added'];
    return back()->withNotify($notify);

}
/////End Articles

///////Youtube///////////////
public function youtubeAll(){
    $doctors = Doctor::all();
    $page_title = 'All Youtube Link Details';
    $sector = Sector::all();
    $education_details = DrYotube::select('doctor_videos.*','doctors.name')
    // ->where('doctor_id', Auth::guard('doctor')->user()->id)
    ->join('doctors', 'doctors.id', '=', 'doctor_videos.doctor_id')
    ->get();
    return view('admin.doctors.youtubelinks',compact('page_title','education_details','sector','doctors'));
}
public function youtubeArticleImage(Request $request)
{
    $image = $request->file('file');
    $imageName = $image->getClientOriginalName();
    $done=$image->move('assets/articles', $imageName);
    return response()->json(['successss' => $imageName]);

    // try{

    //     $location = imagePath()['appointment']['path'];
    //     $size = imagePath()['appointment']['size'];
    //     $image->move($path, $filename);
    //   $staff_image = uploadImage($request->file('file'), $location , $size);

    // }catch(\Exception $exp) {
    //     return 'error Could not upload the image.';
    // }
}


public function youtubeUpdate(Request $request, $id){

    $article = DrYotube::findOrFail($id);



    $article->title = $request->title;
    $article->description = $request->details;
    $article->doctor_id =$request->doctor_id;
    $article->category  =$request->category;
    $article->youtube_link = $request->youtubelink;
    $article->save();

    $notify[] = ['success', 'Youtube Video details has been updated'];
    return back()->withNotify($notify);

}

public function youtubeRemove($id){

    $education_details = DrYotube::findOrFail($id);
    $education_details->delete();

    $notify[] = ['success', 'Youtube Video details successfuly deleted'];
    return back()->withNotify($notify);

}
public function youtubeStore(Request $request){

    // $this->validate($request, [
    //     'title' => 'required|max:190',
    //     'discipline' => 'required|max:190',
    //     'period' => 'required|max:190',
    // ]);

    // DrArticles::create([
    //     'doctor_id' => 1,
    //     'article_title' => $request->title,
    //     'article_description' => $request->description,
    //     'article_image' => $request->selectedDocument,
    //     'category' => $request->category,
    // ]);
    $article = new DrYotube();
    $article->doctor_id = $request->doctor_id;
    $article->title =  $request->title;
    $article->description =  $request->description;
    $article->youtube_link = 'https://www.youtube.com/embed/'. $request->link;
    $article->category =  $request->category;
    $article->save();
    $notify[] = ['success', 'Article has been added'];
    return back()->withNotify($notify);

}
    public function allCoaches(Request $request){
        $page_title = 'Manage Coaches';
        $empty_message = 'No Coaches found';
        $doctors = Users::Where('user_type','=','coach')->latest();

        if($request->search) {
            $doctors = $doctors->where('first_name', 'LIKE', '%'.$request->search.'%')
                                ->orWhere('last_name', 'LIKE', '%'.$request->search.'%');
        }
        $doctors = $doctors->paginate(getPaginate());
        return view('admin.coaches.list', compact('page_title', 'empty_message', 'doctors'));
    }

    public function activeDoctors()
    {
        $page_title = 'Manage Active Coaches';
        $empty_message = 'No active coach found';
        $doctors = Users::Where('status','=',1)->Where('user_type','=','coach')->latest()->paginate(getPaginate());
        return view('admin.coaches.list', compact('page_title', 'empty_message', 'doctors'));
    }

    public function bannedDoctors()
    {
        $page_title = 'Banned Coaches';
        $empty_message = 'No banned coach found';
        $doctors = Users::Where('status','=',0)->Where('user_type','=','coach')->latest()->paginate(getPaginate());
        return view('admin.coaches.list', compact('page_title', 'empty_message', 'doctors'));
    }

    public function emailUnverifiedDoctors()
    {
        $page_title = 'Email Unverified Doctors';
        $empty_message = 'No email unverified doctor found';
        $doctors = Doctor::emailUnverified()->latest()->paginate(getPaginate());
        return view('admin.doctors.list', compact('page_title', 'empty_message', 'doctors'));
    }
    public function emailVerifiedDoctors()
    {
        $page_title = 'Email Verified Doctors';
        $empty_message = 'No email verified doctor found';
        $doctors = Doctor::emailVerified()->latest()->paginate(getPaginate());
        return view('admin.doctors.list', compact('page_title', 'empty_message', 'doctors'));
    }


    public function smsUnverifiedDoctors()
    {
        $page_title = 'SMS Unverified Doctors';
        $empty_message = 'No sms unverified doctor found';
        $doctors = Doctor::smsUnverified()->latest()->paginate(getPaginate());
        return view('admin.doctors.list', compact('page_title', 'empty_message', 'doctors'));
    }
    public function smsVerifiedDoctors()
    {
        $page_title = 'SMS Verified Doctors';
        $empty_message = 'No sms verified doctor found';
        $doctors = Doctor::smsVerified()->latest()->paginate(getPaginate());
        return view('admin.doctors.list', compact('page_title', 'empty_message', 'doctors'));
    }
//////////////////////////////////Coach CRUD///////////////////////////////
    public function newCoach(){
        $page_title = 'Add New Coach';
        $sectors = Http::get('https://gist.githubusercontent.com/mshafrir/2646763/raw/8b0dbb93521f5d6889502305335104218454c2bf/states_titlecase.json');
        $locations = Location::latest()->get();
        return view('admin.coaches.new', compact('page_title','sectors','locations'));
    }

    public function storeCoach(Request $request){
        $request->validate([
                'image' => ['required'],
                'first_name' => 'required|string|max:191',
                'last_name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users',
                'mobile' => 'required|string|max:191',
                'password' => 'required|string|min:6|confirmed',
                'about' => 'required',
            ]);

        $coach_image = '';
        if($request->image) {
            try{
                $location = imagePath()['coach']['path'];
                $coach_image = uploadImageData($request->image, $location);
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $coach = new Users();
        $coach->user_code = Uuid::generate(4);
        $coach->profile_image = $coach_image;
        $coach->user_type =  'coach';
        $coach->first_name =  $request->first_name;
        $coach->last_name = $request->last_name;
        $coach->email =  $request->email;
        $coach->mobile_no =  $request->mobile;
        $coach->bio =$request->about;
        $coach->state =$request->state;
        $coach->district =$request->district;
        $coach->password =  Hash::make($request->password);
        $coach->save();

        notify($coach, 'COACH_CREDENTIALS', [
            'username' => $coach->username,
            'password' => $request->password,
        ]);

        $notify[] = ['success', 'Coach details has been added'];
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $page_title = 'Coach Detail';
        $doctor = Users::findOrFail($id);
        $sectors = Sector::latest()->get();
        $sectors = Http::get('https://gist.githubusercontent.com/mshafrir/2646763/raw/8b0dbb93521f5d6889502305335104218454c2bf/states_titlecase.json');
        $locations = Location::latest()->get();
        $total_online_earn = Deposit::where('doctor_id',$doctor->id)->where('status',1)->sum('amount');
        $total_cash_earn = $doctor->balance - $total_online_earn;
        $appointment_done = Appointment::where('doctor_id',$doctor->id)->where('try',1)->where('is_complete',1)->count();
        $appointment_trashed = Appointment::where('doctor_id',$doctor->id)->where('d_status',1)->count();
        $total_appointment = Appointment::where('doctor_id',$doctor->id)->where('try',1)->count();
        return view('admin.coaches.detail', compact('page_title', 'doctor','sectors','locations','total_online_earn','total_cash_earn','appointment_done','total_appointment','appointment_trashed'));
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
                'image' => ['nullable'],
                'first_name' => 'required|string|max:191',
                'last_name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,'.$id,
                'mobile' => 'required|string|max:191',
                'about' => 'required',
            ]);

        $coach =Users::findOrFail($id);
        if ($request->email != $coach->email && Users::whereEmail($request->email)->whereId('!=', $coach->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }

        if($request->image) {
            try{
                $location = imagePath()['coach']['path'];
                $coach->profile_image = uploadImageData($request->image, $location) ?? '';
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $coach->user_type =  'coach';
        $coach->first_name =  $request->first_name;
        $coach->last_name = $request->last_name;
        $coach->email =  $request->email;
        $coach->mobile_no =  $request->mobile;
        $coach->bio =$request->about;
        $coach->status =$request->status=='on'?1:0;
        $coach->state =$request->state;
        $coach->district =$request->district;
        $coach->save();


        $notify[] = ['success', 'Coach detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function passwordReset(Request $request, $id)
    {
        $request->validate([
                'password' => 'required|string|min:6|confirmed'
            ]);

        $coach = Users::findOrFail($id);

        $coach->password = bcrypt($request->password);
        if($coach->save()) {
            $notify[] = ['success', 'Coach`s password reset successfuly'];
            return redirect()->back()->withNotify($notify);
        }

        $notify[] = ['success', 'Coach`s password reset failed'];
        return redirect()->back()->withNotify($notify);
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $doctors = Doctor::where(function ($doctor) use ($search) {
            $doctor->where('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%");
        });
        $page_title = '';
        switch ($scope) {
            case 'active':
                $page_title .= 'Active ';
                $doctors = $doctors->where('status', 1);
                break;
            case 'banned':
                $page_title .= 'Banned';
                $doctors = $doctors->where('status', 0);
                break;
            case 'emailUnverified':
                $page_title .= 'Email Unerified ';
                $doctors = $doctors->where('ev', 0);
                break;
            case 'smsUnverified':
                $page_title .= 'SMS Unverified ';
                $doctors = $doctors->where('sv', 0);
                break;
        }
        $doctors = $doctors->paginate(getPaginate());
        $page_title .= 'User Search - ' . $search;
        $empty_message = 'No search result found';
        return view('admin.doctors.list', compact('page_title', 'search', 'scope', 'empty_message', 'doctors'));
    }

    public function doctorLoginHistory($id)
    {
        $doctor = Doctor::findOrFail($id);
        $page_title = 'User Login History - ' . $doctor->username;
        $empty_message = 'No Doctors login found.';
        $login_logs = $doctor->login_logs()->latest()->paginate(getPaginate());
        return view('admin.doctors.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function loginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Doctor Login History Search - ' . $search;
            $empty_message = 'No search result found.';
            $login_logs = DoctorLogin::whereHas('doctor', function ($query) use ($search) {
                $query->where('username', $search);
            })->latest()->paginate(getPaginate());
            return view('admin.doctors.logins', compact('page_title', 'empty_message', 'search', 'login_logs'));
        }
        $page_title = 'Doctor Login History';
        $empty_message = 'No doctors login found.';
        $login_logs = DoctorLogin::latest()->paginate(getPaginate());
        return view('admin.doctors.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        $page_title = 'Login By - ' . $ip;
        $login_logs = DoctorLogin::where('doctor_ip',$ip)->latest()->paginate(getPaginate());
        $empty_message = 'No doctors login found.';
        return view('admin.doctors.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function showEmailSingleForm($id)
    {
        $doctor = Doctor::findOrFail($id);
        $page_title = 'Send Email To: ' . $doctor->username;
        return view('admin.doctors.email_single', compact('page_title', 'doctor'));
    }

    public function sendEmailSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        $doctor = Doctor::findOrFail($id);
        send_general_email($doctor->email, $request->subject, $request->message, $doctor->username);
        $notify[] = ['success', $doctor->username . ' will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function showEmailAllForm()
    {
        $page_title = 'Send Email To All Doctors';
        return view('admin.doctors.email_all', compact('page_title'));
    }

    public function sendEmailAll(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        foreach (Doctor::where('status', 1)->cursor() as $doctor) {
            send_general_email($doctor->email, $request->subject, $request->message, $doctor->username);
        }

        $notify[] = ['success', 'All Doctors will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function schedule($id)
    {
        $page_title = 'Manage Schedules';
        $coach = Users::where('user_code','=',$id)->first();
        return view('admin.coaches.Availability.schedule_coaches',compact('page_title','coach'));
    }

    public function scheduleEditGet($avail_code, $date = false)
    {
        $page_title = 'Manage Coach Availability'; 

        $availability = CoachAvailabilityModel::where('coach_availability.avail_code',$avail_code)->first();
        $availability_deatils = CoachAvailableDetail::where('coach_availability_detail.avail_code',$avail_code)->orderby('date', 'asc')->get();

        return view('admin.coaches.Availability.edit_availability' , compact('avail_code','date','page_title','availability' ,'availability_deatils'));
    }

    public function scheduleManage(Request $request) 
    {   
        $request->validate([
            'from_date' => ['required', 'date', 'before_or_equal:to_date', new CoachAvailabilityDateRangeOverlap($request->coach_code)],
            'to_date' => ['required', 'date', 'after_or_equal:from_date', new CoachAvailabilityDateRangeOverlap($request->coach_code)],
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time',
            'description' => 'sometimes|required',
            'days' => [new CoachAvailabilityRecurringScheduleValidate($request->from_date, $request->to_date)],
        ], ['start_time' => 'The start time must be a date before end time.', 'end_time' => 'The end time must be a date after start time.']);

        $slot_Week = [];
        if($request->days != null){
            $slot_Week = array_filter($request->days);
        }
        $final_available_slots = array_values($slot_Week);

        $start_time_15 = Carbon::parse($request->start_time);
        $start_time_30 = Carbon::parse($request->start_time);
        $start_time_60 = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);
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
        $coach_availability->slots = $final_available_slots;
        $coach_availability->save();

        for ($i=0; $i <= $total_dates; $i++) {
            $coach_availability_details = new CoachAvailableDetail();
            $coach_availability_details->avail_code = $coach_availability->avail_code;
            $coach_availability_details->date = date('Y-m-d',strtotime($start_date));

            if(in_array(strtoupper(substr($start_date->format('l'), 0, 2)), $final_available_slots)){
                $coach_availability_details->status = 1;
                $coach_availability_details->time_slots_15 = $serial_or_slot_15;
                $coach_availability_details->time_slots_30 = $serial_or_slot_30;
                $coach_availability_details->time_slots_60 = $serial_or_slot_60;
            }
            elseif(count((array)$final_available_slots)==0){
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
            $start_date->addDays(1);
        }

        $notify[] = ['success', 'Availability added.'];
        return back()->withNotify($notify);
    }

    public function allCoachesForAvailability(Request $request) {
        $page_title = 'Manage Coaches Availability';
        $empty_message = 'No Coaches found';

        $coaches = Users::where('user_type', 'coach');

        if($request->search) {
            $search = trim($request->search);
            $coaches = $coaches->where('email', 'like', "%$search%")
                                ->orWhere('mobile_no', 'like', "%$search%")
                                ->orWhere('first_name', 'like', "%$search%")
                                ->orWhere('last_name', 'like', "%$search%");
        }

        $coaches = $coaches->latest()->paginate(getPaginate());

        return view('admin.coaches.Availability.coach_list', compact('page_title', 'empty_message', 'coaches'));
    }

    public function allAvailabilityOfCoach($id){
        $page_title = 'Manage Coach Availability';
        $availability = CoachAvailabilityModel::where('coach_code',$id)->paginate(getPaginate());
    
        return view('admin.coaches.Availability.coach_availability_list', compact('page_title', 'availability'));
    }

    public function deleteAvailabilityOfCoach($id){

        $availability = CoachAvailabilityModel::where('id',$id)->first();
        if($availability->delete()) {
            CoachAvailableDetail::where('avail_code', $availability->avail_code)->delete();
            $notify[] = ['success', 'Availability deleted.'];
            return back()->withNotify($notify);
        }

        $notify[] = ['error', 'Availability delete failed.'];
        return back()->withNotify($notify);
    }

    public function scheduleEditUpdate(Request $request)
    {
        $avail_code = $request->avail_code;
        $date = $request->date;
        // $time_slots_30 = $request->time_slots_15;
        $time_slots_30 = $request->time_slots_30;
        $time_slots_60 = $request->time_slots_60;

        $availability_deatils = CoachAvailableDetail::where('avail_code', $avail_code)->where('date', $date)->first();

        try {
            
            // $availability_deatils->time_slots_15
            $availability_deatils->time_slots_30 = $time_slots_30;
            $availability_deatils->time_slots_60 = $time_slots_60;

            $availability_deatils->save();

            // return response()->route('')
            return redirect()->route('admin.scheduleEdit.all', [$avail_code, $date])->withNotify(['success' => 'time slot/s successfuly updated']);
        } catch (Exception $e) {
            // 
            return redirect()->route('admin.scheduleEdit.all', [$avail_code, $date])->withNotify(['success' => 'time slot/s update failed']);
        }
    }
}
