<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Books;
use App\Doctor;
use App\GeneralSetting;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class BooksController extends Controller
{
    public function books(){
        $page_title = 'Manage Books';
        $empty_message = 'No sector found';
        $books = Books::latest()->paginate(getPaginate());
        return view('admin.books.books', compact('page_title', 'empty_message','books'));
    }

    public function storeBooks(Request $request){

        $article = new Books();
        $article->book_name = $request->book_name;
        $article->author =  $request->author;
        $article->price =  $request->price;
        $article->description = $request->description;
        $article->book_link =  $request->selectedDocument[1];
        $article->cover_page = $request->selectedDocument[0];
        $article->save();
        $notify[] = ['success', 'Article has been added'];
        return back()->withNotify($notify);
    }

    public function updateBooks(Request $request,$id){

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
    public function booksUpload(Request $request)
{
    $image = $request->file('file');
    $imageName = $image->getClientOriginalName();
    $done=$image->move('assets/books', $imageName);
    return response()->json(['successss' => $imageName]);


}
public function bookRemove($id){

    $education_details = Books::findOrFail($id);
    $education_details->delete();

    $notify[] = ['success', 'Book successfuly deleted'];
    return back()->withNotify($notify);

}
}
