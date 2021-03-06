<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pages;
use App\Images;
use APP\PageImages;
use Faker\Provider\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MediaUploadController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function uploadForm()
    {

        return view('Backend.Modules.uploadmedia');
    }
    ///Upload media function
    public function UploadMedia(Request $request, Images $images, Storage $storage)
    {

        //Save the files in the a folder -> storage/app/public/uploads/UUIDHAS/,[imagename.xxx]

        if ($request->file('image')->isValid()) {
            $validated = $request->validate([
                'image' => 'mimes:jpeg,png|max:1014',
            ]);
            $extension = $request->file('image')->extension();
            $image_original_name = $request->file('image')->getClientOriginalName();
            $image_hashName = Str::random(50);
            $request->file('image')->storeAs('/public/uploads/' . $image_hashName . '/', $image_original_name);
            Storage::url($image_original_name);
            $images->create([
                'image_name' => $image_original_name,
                'image_hash' => $image_hashName,
                'path_to' => 'storage/uploads/' . $image_hashName . '/',
            ]);

           $lastimage = $images->get()->last();
              //  dd($last);
            $success_message = "Image " . $image_original_name . " has been uploaded";
            return response()->json(['success' => $success_message,  'lastadded' => $lastimage]);
        } else {
            return response()->json();
        }

    }
    //SHOW IMAGES ON uploadmedia.blade template
    public function Show(Images $images)
    {
        $all_images = $images->get();
        return view('Backend.Modules.uploadmedia', ['images' => $all_images]);
    }
    //PASS TO AJAX THE LAST IMAGE THAT WAS UPLOADED
    public function LastImageUploaded(Images $images){
       $lastimage = $images->get()->last();
       return response()->json($lastimage);
    }
    //AJAX GET WILL CALL THIS
    public function getImageInfoByID(Images $images, $id){
       $imageinfo =  $images->findorfail($id);
       return response()->json($imageinfo);
    }
    //Deleting IMAGES
    public function DeleteImages(Images $images, Request $request){

        //Delete File directory
        //file $request->path_to, may need to substring the trailing slash

       // Storage::disk('public')->delete('uploads/'.$request->image_hash."/".$request->image_name); //Deletes the files

        Storage::disk('public')->deleteDirectory('uploads/'.$request->image_hash."/"); // Deletes the directory

        //GET it from AJAX
        $images->where('id', $request->id)->forceDelete();
        $success_message = "Image $request->image_name has been deleted!!!";
        return response()->json(['success' => $success_message]);

    }
    //Update Image Information
    public function UpdateImageInformation(Images $images, Request $request){
        //Check if given information is not empty
        $images->where('id', $request->id)->update([
            'alttext' => $request->alttext,
            'caption' => $request->caption
        ]);
        $success_message = "Image has been updated";
        return response()->json(['success' => $success_message]);
    }

    /**
     * Utilize the PageImages Model to create relationship between Pages and Images
     * pages_id links with image_id
     * page 1 has the following images => 2,3,4 or image 2 is used in two pages image 2 pages 1,3
     * table reference id pages_id image_id
     *                  1   1       2
     *                  2   1       3
     *                  3   1       4
     *                  4   3       2
     */

}
