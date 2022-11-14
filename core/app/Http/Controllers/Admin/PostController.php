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
use App\Rules\FileTypeValidate;
use App\Sector;
use App\DoctorAssistantTrack;
use App\DrArticles;
use App\DrYotube;
use App\Gallery;
use App\PostsModel;
use App\Users;
use Illuminate\Support\Facades\Hash;
use Uuid;
use Illuminate\Http\Request;
use Vimeo\Laravel\Facades\Vimeo;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Storage;
use App\WebinarModel;
class PostController extends Controller
{
   ///////Articles///////////////
   public function newPost() {
        $page_title = 'Add New Article';
        $sector = Sector::all();
        $vimeo= Vimeo::request('/me/videos', ['per_page' => 10], 'GET');
        $vimeoData =$vimeo['body']['data'];
           $authors = Users::Where('user_type','=','author')->latest()->paginate(getPaginate());

        return view('admin.Posts.new_post', compact('page_title','sector','vimeoData','authors'));
    }

    public function postsAll(){

        $page_title = 'Manage Articles';
            $empty_message = 'No post found';
            $articles = PostsModel::Select('posts.*','sectors.name')->join('sectors','sectors.id','posts.category')->latest()->paginate(getPaginate());

            return view('admin.Posts.all_posts', compact('page_title', 'empty_message', 'articles'));
    }

    public function uploadPostsImage(Request $request)
    {
        $image = $request->file('file');
        $storagePath=Storage::disk('do_spaces')->putFile('assets/posts/documents', $image, 'public');
        $storageName = basename($storagePath);
        
        return response()->json(['successss' => $storageName]);
    }

    public function postsRemove($id){

        $education_details = DrArticles::findOrFail($id);
        $education_details->delete();

        $notify[] = ['success', 'Article successfuly deleted'];
        return back()->withNotify($notify);
    }

    public function postsStore(Request $request){
        $this->validate($request, [
            'title' => 'required|max:190',
            'description' => 'required',
            'author_id' => 'required',
            'category' => 'required',
            // 'image' => ['required',new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'image' => ['required'],
        ]);
        
        $subject_image='default.jpg';
        if($request->image) {
            try{
                $location = imagePath()['posts']['path'];
                $subject_image = uploadImageData($request->image, $location);
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $author = Users::find($request->author_id);

        $post = new PostsModel();
        $post->post_code = Uuid::generate(4);
        $post->title =  $request->title;
        $post->description =  $request->description;
        $post->category = $request->category;
        $post->post_image =  $subject_image;
        $post->document_name =  $request->selectedDocument[0]??null;
        $post->video_url =  $request->vimeo_url;
        $post->author_name =  $author->first_name . ' '.$author->last_name;
        $post->author_id =  $request->author_id;
        $post->author_description  =  $request->author_description;
        $post->additional_data =  '{}';
        $post->added_by_user =  1;
        $post->webinar_code = $request->webinar ?? null;
        $post->status =  $request->status=='on'?1:0;
        $post->is_daily_dose =  $request->is_daily_dose=='on'?1:0;
        $post->save();
        $notify[] = ['success', 'Article has been added'];
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $page_title = 'Article Detail';
        $article = PostsModel::findOrFail($id);
        $sector = Sector::latest()->get();
        $vimeo= Vimeo::request('/me/videos', ['per_page' => 10], 'GET');
        $vimeoData =$vimeo['body']['data'];
        $authors = Users::Where('user_type','=','author')->latest()->paginate(getPaginate());

        return view('admin.Posts.detail', compact('page_title', 'article','sector','vimeoData','authors'));
    }

    public function postsUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:190',
            'description' => 'required',
            'author_id' => 'required',
            'category' => 'required',
            'image' => ['nullable'],
        ]);

        $subject_image='';
        if($request->image) {
            try{
                $location = imagePath()['posts']['path'];
                $subject_image = uploadImageData($request->image, $location);
            }
            catch(\Exception $exp) { 
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $author = Users::find($request->author_id);

        $post = PostsModel::findOrFail($id);
        $post->title =  $request->title;
        $post->description =  $request->description;
        $post->category = $request->category;
        if($subject_image!=''){
            $post->post_image =  $subject_image;
        }

        $post->document_name =  $request->document;
        $post->video_url =  $request->vimeo_url;
        $post->author_name =  $author->first_name . ' '.$author->last_name;
        $post->author_id =  $request->author_id;
        $post->author_description  =  $request->author_description;
        $post->status =  $request->status=='on'?1:0;
        $post->is_daily_dose =  $request->is_daily_dose=='on'?1:0;
        $post->save();
        $notify[] = ['success', 'Post has been Updated'];
        return back()->withNotify($notify);
    }

    public function postDocDownload($document_name)
    {
        $url='https://localhost/principalsadmin/assets/posts/documents/'.$document_name;
        $headers = ['Content-Type: application/pdf'];
        $newName = "demo.pdf";

        return response()->download($url,$newName,$headers);

    }
    /////End Articles

}
