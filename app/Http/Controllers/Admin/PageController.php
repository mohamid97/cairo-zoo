<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Models\Admin\Lang;
use App\Models\Admin\Page;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PageController extends Controller
{
    //
    public $langs = [];
    public function __construct()
    {
        $this->langs = Lang::all();
    }


    public function index(Request $request)
    {
        $query = Page::withTrashed();
        if($request->has('search') && !empty($request->search) ){
            $searchTerm = $request->search;
            $query->whereHas('translations', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
        $pages = $query->paginate(5);
        return view('admin.pages.index' , ['pages'=>$pages , 'langs'=>$this->langs , 'searchTerm' =>$request->search ?? ''  ]);
    }

    public function create(){
        return view('admin.pages.add' , ['langs'=>$this->langs]);
    }

    public function edit($id){
        $page = Page::findOrFail($id);
        return view('admin.pages.edit' , ['langs' => $this->langs , 'page'=>$page]);
    }

    public function store(StorePageRequest $request){
        $image_name = null;
        if($request->has('image')){
            $image_name = $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/images/pages'), $image_name);

        }
        $page = Page::create([
            'image'=>$image_name
        ]);
        foreach ($this->langs as $lang){
            $page->{'name:'.$lang->code}         = $request->name[$lang->code];
            $page->{'meta_title:'.$lang->code}         = $request->meta_title[$lang->code];
            $page->{'meta_des:'.$lang->code}         = $request->meta_des[$lang->code];
            $page->{'alt_image:'.$lang->code}         = $request->alt_image[$lang->code];
            $page->{'title_image:'.$lang->code}         = $request->title_image[$lang->code];
            $page->{'slug:'.$lang->code}         = $request->slug[$lang->code];
            $page->{'des:'.$lang->code}         = $request->des[$lang->code];
        }

        $page->save();

        Alert::success('Page Created Successfully !');
        return redirect()->back();


    }


    public function update(StorePageRequest $request , $id){
        $page = Page::findOrFail($id);
        if($request->has('image')){
            $image_name = $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/images/pages'), $image_name);
            if (isset($page->image) && file_exists(public_path('uploads/images/pages/' .$page->image))) {
                unlink(public_path('uploads/images/pages/' .$page->image));
            }

            $page->update([
                'image'=>$image_name
            ]);
        }


        foreach ($this->langs as $lang){
            $page->{'name:' . $lang->code} = $request->name[$lang->code];
            $page->{'meta_title:'.$lang->code}         = $request->meta_title[$lang->code];
            $page->{'meta_des:'.$lang->code}         = $request->meta_des[$lang->code];
            $page->{'alt_image:'.$lang->code}         = $request->alt_image[$lang->code];
            $page->{'title_image:'.$lang->code}         = $request->title_image[$lang->code];
            $page->{'slug:' . $lang->code} = $request->slug[$lang->code];
            $page->{'des:' . $lang->code} = $request->des[$lang->code];
        }

        $page->save();


        Alert::success('Page Updated Successfully !');
        return redirect()->back();


    }

    public function destroy($id){
        $page = Page::findOrFail($id);
        $page->forceDelete();
        Alert::success('success', 'Page Deleted Successfully !');
        return redirect()->route('admin.pages.index');


    }

    public function soft_delete($id){
        $page = Page::findOrFail($id);
        $page->delete();
        Alert::success('success', 'Page Soft Deleted Successfully !');
        return redirect()->route('admin.pages.index');
    }




    public function restore($id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        $page->restore();
        Alert::success('success', 'Page Restored Successfully !');
        return redirect()->route('admin.pages.index');

    }






}
