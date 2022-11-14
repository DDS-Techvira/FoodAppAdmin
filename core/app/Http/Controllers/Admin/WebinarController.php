<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Appointment;
use App\Assistant;
use App\Deposit;
use App\Disease;
use App\Doctor;
use App\DoctorLogin;
use App\Location;
use App\Rules\FileTypeValidate;
use App\Sector;
use App\DoctorAssistantTrack;
use App\DrArticles;
use App\DrYotube;
use App\Gallery;
use App\PostsModel;
use App\WebinarModel;
use App\WebinarUsersModel;
use App\Users;
use Illuminate\Support\Facades\Hash;
use Uuid;
use Vimeo\Laravel\Facades\Vimeo;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Storage;

class WebinarController extends Controller
{
    ///////Articles///////////////
    public function newWebinar(){
        $page_title = 'Create New Webinar';
        $sector = Sector::all();
        $vimeo= Vimeo::request('/me/videos', ['per_page' => 10], 'GET');
        $vimeoData =$vimeo['body']['data'];
        $authors = Users::Where('user_type','=','coach')->latest()->paginate(getPaginate());
        return view('admin.Webinar.new_webinar', compact('page_title','sector','vimeoData','authors'));
    }

    public function webinarAll(){

        $page_title = 'All Webinars';
        $empty_message = 'No Wedinar found';
        $articles = WebinarModel::Select('webinar.*','users.first_name','users.last_name')->join('users','users.user_code','webinar.coach_code')->latest()->paginate(getPaginate());

        return view('admin.Webinar.all_webinars', compact('page_title', 'empty_message', 'articles'));
    }

    public function uploadPostsImage(Request $request)
    {
        $image = $request->file('file');
        // $imageName = $image->getClientOriginalName();
        // $done=$image->move('assets/posts/documents', $imageName);
        $storagePath=Storage::disk('do_spaces')->putFile('assets/posts/documents', $image, 'public');
        $storageName = basename($storagePath);
        return response()->json(['successss' => $storageName]);
    
        // try{
    
        //     $location = imagePath()['appointment']['path'];
        //     $size = imagePath()['appointment']['size'];
        //     $image->move($path, $filename);
        //   $staff_image = uploadImage($request->file('file'), $location , $size);
    
        // }catch(\Exception $exp) {
        //     return 'error Could not upload the image.';
        // }
    }

    public function webinarUsers($id)
    {
     $page_title = 'Manage Webinar Users';
     $empty_message = 'No Users found';
     $users = WebinarUsersModel::Where('webinar_users.webinar_code','=',$id)->join('users','users.user_code','webinar_users.prinicpal_code')->Select('webinar_users.*','users.first_name','users.last_name','users.profile_image')->get();

     return view('admin.Webinar.webinar_users', compact('page_title', 'empty_message', 'users'));
    }

    public function webinarRemove($id){

     $education_details = DrArticles::findOrFail($id);
     $education_details->delete();

     $notify[] = ['success', 'Article successfuly deleted'];
     return back()->withNotify($notify);
    }

    public function webinarStore(Request $request){
        $this->validate($request, [
            'title' => 'required|max:190',
            'duration' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
     
        $coach = Users::find($request->author_id);
     
        $post = new WebinarModel();
        $post->webinar_code = Uuid::generate(4);
        $post->title =  $request->title;
        $post->coach_code =  $coach->user_code;
        $post->time =  $request->time;
        $post->date = $request->date;
        $post->duration =  $request->duration;
        $post->description =  $request->description;
        $post->status =  1;
        $post->save();
        $notify[] = ['success', 'Webinar has been added'];
     
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $page_title = 'Webinar Detail';
        $webinar = WebinarModel::where('webinar_code', $id)->first();

        $sector = Sector::all();
        $vimeo= Vimeo::request('/me/videos', ['per_page' => 10], 'GET');
        $vimeoData =$vimeo['body']['data'];
        $authors = Users::Where('user_type','=','coach')->latest()->get();

        return view('admin.Webinar.detail', compact('page_title', 'webinar', 'authors', 'sector', 'vimeo', 'vimeoData'));
    }

    public function webinarUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:190',
            'duration' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        $author = Users::find($request->author_id);

        $webinar = WebinarModel::findOrFail($id);
        $webinar->title =  $request->title;
        $webinar->description =  $request->description ?? null;
        $webinar->coach_code =  $author->user_code ?? null;
        $webinar->duration =  $request->duration;
        $webinar->date =  $request->date;
        $webinar->time =  $request->time;

        $webinar->save();
        $notify[] = ['success', 'Webinar has been Updated'];
        return back()->withNotify($notify);
    }
     
    public function webinarDocDownload($document_name)
    {
     $url='https://localhost/principalsadmin/assets/posts/documents/'.$document_name;
     $headers = ['Content-Type: application/pdf'];
     $newName = "demo.pdf";

     return response()->download($url,$newName,$headers);

    }

    public function activate(Request $request)
    {
     $request->validate(['code_webinar' => 'required']);
     $gateway = WebinarUsersModel::where('webinar_users.prinicpal_code', $request->code_principal)
     ->where('webinar_users.webinar_code', $request->code_webinar)->update(['status' => 1]);

     $notify[] = ['success','User has been activated.'];
     return back()->withNotify($notify);
    }

    public function deactivate(Request $request)
    { 
     $request->validate(['code_webinar' => 'required']);
     $gateway = WebinarUsersModel::where('webinar_users.prinicpal_code','=', $request->code_principal)
                ->where('webinar_users.webinar_code', $request->code_webinar)->update(['status' => 0]);

     $notify[] = ['success','User has been disabled.'];
     return back()->withNotify($notify);
    }

    public function delete($code, Request $request)
    {  
    WebinarUsersModel::where('webinar_code', $code)->delete();
    WebinarModel::where('webinar_code', $code)->delete();

    $notify[] = ['success','Webinar has been deleted.'];
    return back()->withNotify($notify);
    }
    /////End Articles

}
 