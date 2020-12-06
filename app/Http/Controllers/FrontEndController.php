<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    //frontend index page

    public function index(){

        return view("frontend.pages.index");
    }
}
