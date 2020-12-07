<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pages;
use App\Images;
use Faker\Provider\Image;

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
    public function UploadMedia(Request $request, Images $images)
    {

        //Save the files in the a folder -> public/storage/images/all_media/images.
        //$request->file('imagefile')->store('public/storage/images/all_media/images');







        $image_hashName = $request->file('imagefile')->hashName();
        $image_mimeType = $request->file('imagefile')->getClientMimeType();
        $image_original_name = $request->file('imagefile')->getClientOriginalName();

        $images->create([
            'image_name' => $image_original_name,
            'image_hash' => $image_hashName,
            'path_to' => 'public/storage/images/all_media/images',
        ]);
        $request->file('imagefile')->store('images/all_media/images');
        //dd($image_hashName);
        $success_message = "";
        return redirect()->back()->with('message', $success_message);
    }
    public function Show(Images $images){

        $all_images = $images->get();

        return view('Backend.Modules.uploadmedia', ['images'=> $all_images]);

    }
}
