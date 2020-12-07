<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('frontend.pages.index');
//});

Auth::routes();

Route::get('/', 'FrontEndController@index')->name('home');


/**********Backend-Must-Be-Logged-In************/

//This will be routes for admin/pages section
//Index -> list of all pages
//Create
//Edit
//Delete


Route::get('/admin/pages', 'PagesController@index')->name('Backend.Pages.index');

Route::get('/admin/pages/create', 'PagesController@create')->name('Backend.Pages.create');
Route::post('/admin/pages', 'PagesController@store');

Route::get('/admin/pages/show/{id}', 'PagesController@show')->name('Backend.Pages.show');

Route::get('/admin/pages/edit/{id}', 'PagesController@edit')->name('Backend.Pages.edit');

Route::post('/admin/pages/update', 'PagesController@update');

Route::put('/admin/pages/delete', 'PagesController@destroy')->name('Backend.Pages.destroy');

Route::put('/admin/pages/forcedelete', 'PagesController@permDelete')->name('Backend.Pages.forcedelete');

Route::put('/admin/pages/restore', 'PagesController@restore')->name('Backend.Pages.restore');
Route::post('/admin/pages/publish', 'PagesController@publish')->name('Backend.Pages.publish');

/**
 * AJAX GET DATA METHODS go below
 * 1. Get Draft pages by ID
 * 2. Get new count for Published, Draft and Deleted pags
 * 3. Get
 */

Route::get('/admin/pages/draft/{id}/{status}', 'PagesController@getDraftpageByID');

Route::get('/admin/pages/all/todelete/{id}/{parent}', 'PagesController@getAllNoneDeletedPagesByID');

Route::get('/admin/pages/all/deleted/date/{id}/', 'PagesController@getDeletedAtInfoAfterDelete');

Route::get('/admin/pages/all/trashed/{id}', 'PagesController@getAllTrashedpagesBYID');

Route::get('/admin/pages/published/count', 'PagesController@getNewPublishedCount');

//This will be routes for admin/services section
    //Index -> list of all services
    //Create
    //Edit
    //Delete

//This will be routes for the admin/posts section
    //Index -> list of all posts
    //Create
    //Edit
    //Delete


/**
 * This will be the Upload Media Module   Section routes
 *
 */
//Route::get('/admin/modules/media/mediaupload', 'MediaUploadController@uploadForm')->name('Backend.Modules.uploadmedia');
Route::get('/admin/modules/media/mediaupload', 'MediaUploadController@Show')->name('Backend.Modules.uploadmedia');


Route::post('/admin/modules/media/mediaupload/imageupload', 'MediaUploadController@UploadMedia')->name('Backend.Modules.imageupload');

/************************************************************************************** */
/**
 * FRONTEND
 */
