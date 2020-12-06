<?php

namespace App\Http\Controllers;

use App\childpages;
use App\pages;
use App\page_slugs;
use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PagesController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(pages $pages, childpages $childpages)
    {
        //Lists all the available pages.
        //Backend/Pages/index
        $pageslist = $pages
            ->select('pages.title', 'pages.id', 'childpages.parent_page_id', 'pages.created_at', 'pages.updated_at', 'page_slugs.slug')
            ->rightJoin('childpages', 'pages.id', '=', 'childpages.pages_id')->leftJoin('page_slugs', 'pages.id', '=', 'page_slugs.pages_id')->where('pages.active', 1)
            ->get();
        //dd($pageslist);
        $publish_page_count = $pages->where('active', 1)->count();
        $trashed_page_count = $pages->onlyTrashed()->count();
        //dd($trashed_page_count);
        $deleted_pages = $pages->select('pages.*', 'childpages.parent_page_id', 'page_slugs.slug')
            ->rightJoin('childpages', 'pages.id', '=', 'childpages.pages_id')->leftJoin('page_slugs', 'pages.id', '=', 'page_slugs.pages_id')
            ->onlyTrashed()->get();
        // dd($deleted_pages);
        $draft_pages = $pages->select('pages.title', 'pages.id', 'childpages.parent_page_id', 'pages.created_at', 'pages.updated_at')
            ->rightJoin('childpages', 'pages.id', '=', 'childpages.pages_id')
            ->where('pages.active', 0)->get();
        $draft_pages_count = $pages->where('pages.active', 0)->count();
        // dd($draft_pages);


        return view('Backend.Pages.index', [
            'pageslist' => $pageslist,
            'deleted_pages' => $deleted_pages,
            'publishcount' => $publish_page_count,
            'draftcount' => $draft_pages_count,
            'trashed' => $trashed_page_count,
            'draftpages' => $draft_pages
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Creates new pages
        $pageslist = pages::select('id', 'title')->get();
        //Create new page form.
        //Backend/Pages/create
        return view('Backend.Pages.create', ['pageslist' => $pageslist]);
    }

    /**
     * takes in a string and converts it to URI safe straing
     * @return string
     */
    function SlugsCreator($string)
    {
        $string = str_replace(' ', '-', $string);
        $string = strtolower($string);
        $string = preg_replace('/[^A-Za-z0-9-]/', '', $string);
        $string = trim(preg_replace("![^a-z0-9]+!i", "-", $string), '-');
        return $string;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, pages $pages, page_slugs $page_slugs, childpages $childpages)
    {
        //before inserting we need to check and see if the page name is unique or not
        $validatedData = $request->validate([
            'title' => ['required', 'unique:pages', 'max:255'],
            'description' => ['required'],
        ]);
        //otherwise store data into db
        //Elequent method
        //Insert into pages model
        $page = $pages->create([
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'owner' => request('owner')
        ]);

        $page_slugs->create([
            'pages_id' => $page->id,
            'slug' => $this->SlugsCreator(request('slug')),
            'active' => 1
        ]);

        $childpages->create([
            'pages_id' => $page->id,
            'parent_page_id' => (int)request('page_parent')
        ]);
        $success_message = "Page " . request('title') . " has been added to your pages.";
        //return redirect('admin/pages/create');
        return response()->json(['success' => 'Data is successfully added']);
        //return redirect()->back()->with('message', $success_message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function show(pages $pages, $id)
    {
        $slugs = pages::find($id)->page_slugs; //Hasone relationship with pag_slugs table where pages_id = {the page id} in blade use it like $slugs->slug no need to do a loop

        // $slugs = pages::find(1)->page_slugs()->where('pages_id', 2)->first();
        //dd($slugs);
        //
        $pageview = pages::where('id', $id)->get();
        return view('Backend.Pages.show', ['pages' => $pageview, 'slugs' => $slugs]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function edit(pages $pages, $id)
    {
        $all_pages_info =  $pages->select(
            'pages.*',
            'childpages.parent_page_id',
            'page_slugs.slug',
        )
            ->where('pages.id', $id)
            ->rightJoin('childpages', 'pages.id', '=', 'childpages.pages_id')->leftJoin('page_slugs', 'pages.id', '=', 'page_slugs.pages_id')
            ->withTrashed()->get();
        //
        // $slug = pages::find($id)->page_slugs; //Hasone relationship with pag_slugs table where pages_id = {the page id} in blade use it like $slugs->slug no need to do a loop

        // $parent_info = pages::find($id)->childPages()->where('pages_id', $id)->first();
        // dd($parent_info->parent_page_id);

       $pagelist= pages::select('id', 'title')->where('id', '!=', $id)->get(); //Get the data but ensure that self is not included.
        // $editview = pages::where('id', $id)->get();
       // dd($all_pages_info);

        return view('Backend.Pages.edit', ['editview' => $all_pages_info, 'pages'=> $pagelist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pages $pages, childpages $child_pages)
    {
        // dd($request);
        $description = request('description');
        $pages->where('id', $request->page_id)
            ->update([
                'title' => request('title'),
                'subtitle' => request('subtitle'),
                'description' => $description,
                'owner' => request('owner'),
                'publish_start_date' => request('publish_start_date')
            ]);

        $child_pages->where('pages_id', $request->page_id)->update(['parent_page_id' => request('page_parent')]);

        return redirect('admin/pages/edit/' . $request->page_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,pages $pages, childpages $child_pages, page_slugs $page_slugs)
    {
        //
        //Check if the page has any children 1st
        //Find all children if parent is zero
        //look at the page id in parent_page_id column of childpages table

        //  $parent_info = pages::find($id)->childPages()->where('pages_id', $id)->first();
        $parent_info = childpages::where('parent_page_id', $request->id)->get(); // this gets all

        if ($request->parent == 0) {
            foreach ($parent_info as $child) {
                $child_pages->where('parent_page_id', $request->id)->update(['parent_page_id' => 0]);
            }
        }

        //dd($parent_info);
        //if is not zero means the page is a child and not a main and do not change
        $pages->where('id', $request->id)->delete();
        $page_slugs->where('pages_id', $request->id)->delete();

        $child_pages->where('pages_id', $request->id)->delete();


        $success_message = "Page  has been deleted.";
        //return redirect('admin/pages/')->with('message', $success_message);
        return response()->json(['success' => request()]);
    }



 /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function permDelete(Request $request ,pages $pages, childpages $child_pages, page_slugs $page_slugs)
    {
        //
        //Check if the page has any children 1st
        //Find all children if parent is zero
        //look at the page id in parent_page_id column of childpages table

        //  $parent_info = pages::find($id)->childPages()->where('pages_id', $id)->first();
        $parent_info = childpages::where('parent_page_id', $request->id)->get(); // this gets all

        if ($request->parent == 0) {
            foreach ($parent_info as $child) {
                $child_pages->where('parent_page_id', $request->id)->update(['parent_page_id' => 0]);
            }
        }

        //dd($parent_info);
        //if is not zero means the page is a child and not a main and do not change
        $pages->where('id', $request->id)->forceDelete();
        $page_slugs->where('pages_id', $request->id)->forceDelete();

        $child_pages->where('pages_id', $request->id)->forceDelete();


        $success_message = "Page  has been deleted.";
        //return redirect('admin/pages/')->with('message', $success_message);
        return response()->json(['success' => request()]);
    }



    /**
     * Restore the spicific page to the storage
     */
    public function restore(Request $request, pages $pages, page_slugs $page_slugs, childpages $childpages)
    {
        $restore_page = $pages->withTrashed()->find($request->id)->restore();
        $restore_page_slug = $page_slugs->withTrashed()->where('pages_id', $request->id)->restore();
        $restore_child_page_relations = $childpages->withTrashed()->where('pages_id', $request->id)->restore();
        return response()->json(['success' => request()]);
    }

    /***
     * Publish a page
     */
    public function publish(Request $request, pages $pages)
    {
        $pages->where('id', request('page_id'))
            ->update([
                'active' => request('change_status')
            ]);

        return response()->json(['success' => request()]);
       // return redirect('admin/pages');
    }




    /**
     * These are for ajax requests
     *
     */
    public function getDraftpageByID(pages $pages,$id,$status){

        $draftpages = $pages->where('active',$status)->findorfail($id);
        return response()->json($draftpages);

    }
    public function getAllNoneDeletedPagesByID(pages $pages,$id,$parent){
        $nontrashedpages = $pages
        ->select('pages.title', 'pages.id', 'childpages.parent_page_id', 'pages.created_at', 'pages.updated_at', 'page_slugs.slug', 'pages.deleted_at')
        ->rightJoin('childpages', 'pages.id', '=', 'childpages.pages_id')->leftJoin('page_slugs', 'pages.id', '=', 'page_slugs.pages_id')->withTrashed()->findorfail($id);

        return response()->json($nontrashedpages);
    }
    public function getAllTrashedpagesBYID(pages $pages,$id){
        $trashedpages = $pages
        ->select('pages.title', 'pages.id', 'childpages.parent_page_id', 'pages.created_at', 'pages.updated_at', 'page_slugs.slug', 'pages.active')
        ->rightJoin('childpages', 'pages.id', '=', 'childpages.pages_id')->leftJoin('page_slugs', 'pages.id', '=', 'page_slugs.pages_id')->onlyTrashed()->findorfail($id);

        return response()->json($trashedpages);
    }
    public function getDeletedAtInfoAfterDelete(pages $pages,$id){
        $deleted_at = $pages->onlyTrashed()->findorfail($id);
        return response()->json($deleted_at);
    }
    public function getNewPublishedCount(pages $pages){
        $newactivecount = $pages->where('active', 1)->count();
        $draftnewcount = $pages->where('active',0)->count();
        $trashednewcount = $pages->onlyTrashed()->count();
        return response()->json(['newcount' =>$newactivecount, 'draftnewcount'=>$draftnewcount, 'tashedcount' => $trashednewcount]);
    }
}
