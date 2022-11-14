<?php

namespace App\Http\Controllers\Admin;

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
use App\Sector;
use App\DoctorAssistantTrack;
use App\DrArticles;
use App\DrYotube;
use App\Gallery;
use Illuminate\Support\Facades\Hash;

class ManageDoctorsController extends Controller
{
    public function sectors()
    {
        $page_title = 'Manage Category';
        $empty_message = 'No Category found';
        $sectors = Sector::latest()->paginate(getPaginate());
        return view('admin.doctors.sector', compact('page_title', 'empty_message', 'sectors'));
    }

    public function newCategory()
    {
        $page_title = 'Add New Category';
        return view('admin.category.new', compact('page_title'));
    }

    public function storeSectors(Request $request)
    {
        $request->validate([
            'image' => ['required'],
            'name' => 'required|string|max:190|unique:sectors',
            'details' => 'required|string|max:190'
        ]);

        $subject_image = '';
        if($request->image) {
            try{
                $location = imagePath()['sector']['path'];
                $subject_image = uploadImageData($request->image, $location);
            }
            catch(\Exception $exp) { 
                return back()->withNotify([['error', 'Could not upload the image.']]);
            }
        }

        Sector::create([
            'image' => $subject_image,
            'name' => $request->name,
            'details' => $request->details,
            'status' => $request->status ?? 0,
        ]);

        $notify[] = ['success', 'Category details has been added'];
        return back()->withNotify($notify);
    }

    public function detailCategory($id)
    {
        $page_title = 'Category Details';
        $category = Sector::find($id);
        return view('admin.category.detail', compact('page_title', 'category'));
    }

    public function updateSectors(Request $request, $id)
    {

        $request->validate([
            'image' => ['nullable'],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $sector = Sector::findOrFail($id);

        $subject_image = $sector->image;
        if ($request->image) {
            try{
                $location = imagePath()['sector']['path'];
                $subject_image = uploadImageData($request->image, $location);
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $sector->update([
            'image' => $subject_image,
            'name' => $request->name,
            'details' => $request->details,
            'status' => ($request->status == 'on') ? 1 : 0,
        ]);

        $notify[] = ['success', 'Category details has been Updated'];
        return back()->withNotify($notify);
    }

    /////Disease
    public function diseases()
    {
        $page_title = 'Manage Disease';
        $empty_message = 'No diseas found';
        $sectors = Disease::latest()->paginate(getPaginate());
        return view('admin.doctors.disease', compact('page_title', 'empty_message', 'sectors'));
    }

    public function storeDiseases(Request $request)
    {
        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $subject_image = '';
        if ($request->hasFile('image')) {
            try {

                $location = imagePath()['disease']['path'];
                $size = imagePath()['disease']['size'];

                $subject_image = uploadImage($request->image, $location, $size);

            } catch (\Exception $exp) {
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

    public function updateDiseases(Request $request, $id)
    {

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $sector = Disease::findOrFail($id);

        $subject_image = $sector->image;
        if ($request->hasFile('image')) {
            try {

                $location = imagePath()['disease']['path'];
                $size = imagePath()['disease']['size'];
                $old = $sector->image;
                $subject_image = uploadImage($request->image, $location, $size, $old);

            } catch (\Exception $exp) {
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
    public function gallery()
    {
        $page_title = 'Manage Gallery Images';
        $empty_message = 'No images found';
        $sectors = Gallery::latest()->paginate(getPaginate());
        return view('admin.doctors.gallery', compact('page_title', 'empty_message', 'sectors'));
    }

    public function galleryRemove($id)
    {

        $gallery = Gallery::where('id', $id)->findOrFail($id);
        $gallery->delete();

        $notify[] = ['success', 'Image successfuly deleted'];
        return back()->withNotify($notify);

    }

    public function storegallery(Request $request)
    {
        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            // 'name' => 'required|string|max:190',
            // 'details' => 'required|string|max:190'
        ]);

        $subject_image = '';
        if ($request->hasFile('image')) {
            try {

                $location = imagePath()['gallery']['path'];
                $size = imagePath()['gallery']['size'];

                $subject_image = uploadImage($request->image, $location, $size);

            } catch (\Exception $exp) {
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
        $article->status = 1;
        $article->save();

        $notify[] = ['success', 'Gallery details has been added'];
        return back()->withNotify($notify);
    }

    public function updategallery(Request $request, $id)
    {

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'details' => 'required|string|max:190'
        ]);

        $sector = Disease::findOrFail($id);

        $subject_image = $sector->image;
        if ($request->hasFile('image')) {
            try {

                $location = imagePath()['disease']['path'];
                $size = imagePath()['disease']['size'];
                $old = $sector->image;
                $subject_image = uploadImage($request->image, $location, $size, $old);

            } catch (\Exception $exp) {
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


    public function locations()
    {
        $page_title = 'Manage Location';
        $empty_message = 'No location found';
        $locations = Location::latest()->paginate(getPaginate());
        return view('admin.doctors.location', compact('page_title', 'empty_message', 'locations'));
    }

    public function storeLocations(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:190'
        ]);

        Location::create([
            'name' => $request->name,
        ]);

        $notify[] = ['success', 'Location details has been added'];
        return back()->withNotify($notify);
    }

    public function updateLocations(Request $request, $id)
    {

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
    public function articlesAll()
    {
        $sector = Sector::all();
        $doctors = Doctor::all();


        $page_title = 'All Posts Details';
        $education_details = DrArticles::select('doctor_articles.*', 'doctors.name')
            // ->where('doctor_id', Auth::guard('doctor')->user()->id)
            ->join('doctors', 'doctors.id', '=', 'doctor_articles.doctor_id')
            ->get();
        return view('admin.doctors.articles', compact('page_title', 'education_details', 'sector', 'doctors'));
    }

    public function uploadArticleImage(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $done = $image->move('assets/articles', $imageName);
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

    public function articlesStore(Request $request)
    {

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

    public function articlesUpdate(Request $request, $id)
    {

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
        if ($request->hasFile('image')) {
            try {

                $location = imagePath()['articles']['path'];
                $size = imagePath()['articles']['size'];
                $old = $article->article_image;
                $subject_image = uploadImage($request->image, $location, $size, $old);

            } catch (\Exception $exp) {
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
        $article->article_description = $request->details;
        $article->doctor_id = $request->doctor_id;
        $article->category = $request->category;
        $article->article_image = $subject_image;
        $article->save();

        $notify[] = ['success', 'Article details has been updated'];
        return back()->withNotify($notify);

    }

    public function articlesRemove($id)
    {

        $education_details = DrArticles::findOrFail($id);
        $education_details->delete();

        $notify[] = ['success', 'Article successfuly deleted'];
        return back()->withNotify($notify);

    }

    public function articleStore(Request $request)
    {

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
        $article->article_title = $request->title;
        $article->article_description = $request->description;
        $article->article_image = $request->selectedDocument[0];
        $article->category = $request->category;
        $article->save();
        $notify[] = ['success', 'Article has been added'];
        return back()->withNotify($notify);

    }
/////End Articles

///////Youtube///////////////
    public function youtubeAll()
    {
        $doctors = Doctor::all();
        $page_title = 'All Youtube Link Details';
        $sector = Sector::all();
        $education_details = DrYotube::select('doctor_videos.*', 'doctors.name')
            // ->where('doctor_id', Auth::guard('doctor')->user()->id)
            ->join('doctors', 'doctors.id', '=', 'doctor_videos.doctor_id')
            ->get();
        return view('admin.doctors.youtubelinks', compact('page_title', 'education_details', 'sector', 'doctors'));
    }

    public function youtubeArticleImage(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $done = $image->move('assets/articles', $imageName);
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


    public function youtubeUpdate(Request $request, $id)
    {

        $article = DrYotube::findOrFail($id);


        $article->title = $request->title;
        $article->description = $request->details;
        $article->doctor_id = $request->doctor_id;
        $article->category = $request->category;
        $article->youtube_link = $request->youtubelink;
        $article->save();

        $notify[] = ['success', 'Youtube Video details has been updated'];
        return back()->withNotify($notify);

    }

    public function youtubeRemove($id)
    {

        $education_details = DrYotube::findOrFail($id);
        $education_details->delete();

        $notify[] = ['success', 'Youtube Video details successfuly deleted'];
        return back()->withNotify($notify);

    }

    public function youtubeStore(Request $request)
    {

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
        $article->title = $request->title;
        $article->description = $request->description;
        $article->youtube_link = 'https://www.youtube.com/embed/' . $request->link;
        $article->category = $request->category;
        $article->save();
        $notify[] = ['success', 'Article has been added'];
        return back()->withNotify($notify);

    }

    public function allDoctors()
    {
        $page_title = 'Manage Doctors';
        $empty_message = 'No doctor found';
        $doctors = Doctor::latest()->paginate(getPaginate());
        return view('admin.doctors.list', compact('page_title', 'empty_message', 'doctors'));
    }

    public function activeDoctors()
    {
        $page_title = 'Manage Active Doctors';
        $empty_message = 'No active doctor found';
        $doctors = Doctor::active()->latest()->paginate(getPaginate());
        return view('admin.doctors.list', compact('page_title', 'empty_message', 'doctors'));
    }

    public function bannedDoctors()
    {
        $page_title = 'Banned Doctors';
        $empty_message = 'No banned doctor found';
        $doctors = Doctor::banned()->latest()->paginate(getPaginate());
        return view('admin.doctors.list', compact('page_title', 'empty_message', 'doctors'));
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

    public function newDoctor()
    {
        $page_title = 'Add New Doctor';
        $sectors = Sector::latest()->get();
        $locations = Location::latest()->get();
        return view('admin.doctors.new', compact('page_title', 'sectors', 'locations'));
    }

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'image' => ['required', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:doctors',
            'mobile' => 'required|string|max:191|unique:doctors',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|alpha_num|unique:doctors|min:6',
            'sector_id' => 'required|numeric|gt:0',
            'qualification' => 'required|string|max:180',
            'address' => 'required|string|max:191',
            'location_id' => 'required|numeric|gt:0',
            'fees' => 'required|numeric|gt:0',
            'rating' => 'required|numeric|gt:0|max:5',
            'about' => 'required',
        ]);

        $doctor_image = '';
        if ($request->hasFile('image')) {
            try {
                $location = imagePath()['doctor']['path'];
                $size = imagePath()['doctor']['size'];

                $doctor_image = uploadImage($request->image, $location, $size);

            } catch (\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $doctor = Doctor::create([
            'image' => $doctor_image,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'sector_id' => $request->sector_id,
            'qualification' => $request->qualification,
            'address' => $request->address,
            'location_id' => $request->location_id,
            'fees' => $request->fees,
            'rating' => $request->rating,
            'about' => $request->about,
            'featured' => $request->featured ? 1 : 0,
        ]);

        notify($doctor, 'DOCTOR_CREDENTIALS', [
            'username' => $doctor->username,
            'password' => $request->password,
        ]);

        $notify[] = ['success', 'Doctor details has been added'];
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $page_title = 'Doctor Detail';
        $doctor = Doctor::findOrFail($id);
        $assistants = Assistant::where('status', 1)->latest()->get();
        $sectors = Sector::latest()->get();
        $locations = Location::latest()->get();
        $total_online_earn = Deposit::where('doctor_id', $doctor->id)->where('status', 1)->sum('amount');
        $total_cash_earn = $doctor->balance - $total_online_earn;
        $appointment_done = Appointment::where('doctor_id', $doctor->id)->where('try', 1)->where('is_complete', 1)->count();
        $appointment_trashed = Appointment::where('doctor_id', $doctor->id)->where('d_status', 1)->count();
        $total_appointment = Appointment::where('doctor_id', $doctor->id)->where('try', 1)->count();
        return view('admin.doctors.detail', compact('page_title', 'doctor', 'assistants', 'sectors', 'locations', 'total_online_earn', 'total_cash_earn', 'appointment_done', 'total_appointment', 'appointment_trashed'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:doctors,email,' . $doctor->id,
            'mobile' => 'required|string|max:191|unique:doctors,mobile,' . $doctor->id,
            'address' => 'required|string|max:191',
            'sector_id' => 'required|numeric|gt:0',
            'qualification' => 'required|string|max:180',
            'location_id' => 'required|numeric|gt:0',
            'fees' => 'required|numeric|gt:0',
            'rating' => 'required|numeric|gt:0|max:5',
        ]);


        if ($request->email != $doctor->email && Doctor::whereEmail($request->email)->whereId('!=', $doctor->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }
        if ($request->mobile != $doctor->mobile && Doctor::where('mobile', $request->mobile)->whereId('!=', $doctor->id)->count() > 0) {
            $notify[] = ['error', 'Mobile number already exists.'];
            return back()->withNotify($notify);
        }

        $doctor->update([
            'mobile' => $request->mobile,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'sector_id' => $request->sector_id,
            'qualification' => $request->qualification,
            'location_id' => $request->location_id,
            'fees' => $request->fees,
            'rating' => $request->rating,
            'status' => $request->status ? 1 : 0,
            'ev' => $request->ev ? 1 : 0,
            'sv' => $request->sv ? 1 : 0,
            'tv' => $request->tv ? 1 : 0,
            'ts' => $request->ts ? 1 : 0,
            'featured' => $request->featured ? 1 : 0,
        ]);

        $notify[] = ['success', 'Doctor detail has been updated'];
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
        $login_logs = DoctorLogin::where('doctor_ip', $ip)->latest()->paginate(getPaginate());
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
}
