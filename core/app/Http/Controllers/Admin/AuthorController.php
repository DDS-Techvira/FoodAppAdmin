<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Assistant;
use App\Deposit;
use App\Http\Controllers\Controller;
use App\Location;
use App\Plugin;
use App\Rules\FileTypeValidate;
use App\Sector;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Vimeo\Laravel\Facades\Vimeo;
use Uuid;
class AuthorController extends Controller
{
    public function AllAuthors()
    {
        $page_title = 'Manage Authors';
        $empty_message = 'No Authors found';
        $authors = Users::Where('user_type','=','author')->latest()->paginate(getPaginate());
        return view('admin.authors.list', compact('page_title', 'empty_message', 'authors'));
    }

    public function newAuthors(){
        $page_title = 'Add New Authors';
        $sectors = Http::get('https://gist.githubusercontent.com/mshafrir/2646763/raw/8b0dbb93521f5d6889502305335104218454c2bf/states_titlecase.json');
        return view('admin.authors.new', compact('page_title','sectors'));
    }

    public function storeAuthors(Request $request){
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
                $location = imagePath()['author']['path'];
                $coach_image = uploadImageData($request->image, $location);
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $coach = new Users();
        $coach->user_code = Uuid::generate(4);
        $coach->profile_image = $coach_image;
        $coach->user_type =  'author';
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

        $notify[] = ['success', 'Author details has been added'];
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $page_title = 'Authors Detail';
        $author = Users::findOrFail($id);
        $sectors = Sector::latest()->get();
        $sectors = Http::get('https://gist.githubusercontent.com/mshafrir/2646763/raw/8b0dbb93521f5d6889502305335104218454c2bf/states_titlecase.json');
        $locations = Location::latest()->get();
        $total_online_earn = Deposit::where('doctor_id',$author->id)->where('status',1)->sum('amount');
        $total_cash_earn = $author->balance - $total_online_earn;
        $appointment_done = Appointment::where('doctor_id',$author->id)->where('try',1)->where('is_complete',1)->count();
        $appointment_trashed = Appointment::where('doctor_id',$author->id)->where('d_status',1)->count();
        $total_appointment = Appointment::where('doctor_id',$author->id)->where('try',1)->count();
        return view('admin.authors.detail', compact('page_title', 'author','sectors','locations','total_online_earn','total_cash_earn','appointment_done','total_appointment','appointment_trashed'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => ['nullable'],
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,id,'.$id,
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
                $location = imagePath()['author']['path'];
                $coach->profile_image = uploadImageData($request->image, $location);
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $coach->user_type =  'author';
        $coach->first_name =  $request->first_name;
        $coach->last_name = $request->last_name;
        $coach->email =  $request->email;
        $coach->mobile_no =  $request->mobile;
        $coach->bio =$request->about;
        $coach->status = $request->status=='on'?1:0;
        $coach->state =$request->state;
        $coach->district =$request->district;
        $coach->save();


        $notify[] = ['success', 'Authors detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }


    public function AllVideos()
    {
        $page_title = 'Manage Videos';
        $empty_message = 'No Videos found';
        $vimeo= Vimeo::request('/me/videos', ['per_page' => 10], 'GET');
        $videos =$vimeo['body']['data'] ?? [];
        // return $videos;
        return view('admin.my_video.list', compact('page_title', 'empty_message', 'videos'));
    }

    public function newVideo(){
        $page_title = 'Add New Video';
        // $sectors = Http::get('https://gist.githubusercontent.com/mshafrir/2646763/raw/8b0dbb93521f5d6889502305335104218454c2bf/states_titlecase.json');
        return view('admin.my_video.new', compact('page_title'));
    }

    public function storeVideo(Request $request){
        // $this->vimeo->upload('/foo.mp4');
        try {
            Vimeo::upload($request->selected_video);
            $notify[] = ['success', 'Video uploaded to the Vimo'];
            return back()->withNotify($notify);
        } catch (Exception $e) {
            dd($e, $e->getMessage());
        }
    }

}
