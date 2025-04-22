<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagsRequest;
use App\Models\Admin\Lang;
use App\Models\Admin\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TagsController extends Controller
{

    protected $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public  function  index(Request $request){
        $tags = Tags::query();
        $search = $request->search;
        if ($search) {
            $tags->whereHas('translations', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $tags = $tags->paginate(10);
        return view('admin.tags.index' , [
            'tags'=>$tags,
            'search'=>$search,
            'langs'=>$this->langs
        ]);
    }
    //create function
    public  function create(){

        return view('admin.tags.add'  , ['langs'=> $this->langs]);
    }
    public  function store(TagsRequest $request){
        try{

            DB::beginTransaction();
            $tags = Tags::create([
                'status'=>'1'
            ]);
            foreach ($this->langs as $lang) {
                $tags->{'name:'.$lang->code}         = $request->name[$lang->code];
                $tags->{'slug:'.$lang->code}         = $request->slug[$lang->code];
                $tags->{'meta_title:'.$lang->code}   = $request->meta_title[$lang->code];
                $tags->{'meta_des:'.$lang->code}     = $request->meta_des[$lang->code];

            }
            $tags ->save();
            // commit transaction
            DB::commit();
            Alert::success('Success', 'Created Successfully !');
            return redirect()->route('admin.tags.index');

        }catch (\Exception $e){
            dd($e->getLine() , $e->getMessage());
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.tags.index');
        }

    } //end store function



    //edit tags
    public  function edit($id){
        $tag = Tags::findOrFail($id);
        return view('admin.tags.edit' , ['tag'=>$tag , 'langs'=>$this->langs]);
    }


    public function update(TagsRequest $request , $id){
        try{

            DB::beginTransaction();
            $tag = Tags::findOrFail($id);
            $tag->update([
                'status'=>'1'
            ]);
            foreach ($this->langs as $lang) {
                $tag ->{'name:'.$lang->code}         = $request->name[$lang->code];
                $tag ->{'slug:'.$lang->code}         = $request->slug[$lang->code];
                $tag ->{'meta_title:'.$lang->code}   = $request->meta_title[$lang->code];
                $tag ->{'meta_des:'.$lang->code}     = $request->meta_des[$lang->code];

            }
            $tag ->save();
            DB::commit();
            Alert::success('Success', 'Updated successfully  !');
            return redirect()->route('admin.tags.index');
        }catch (\Exception $e){
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.tags.index');
        }

    } // end update function


    // delete tag
    public  function delete($id){
        $tag = Tags::findOrFail($id);
        $tag->delete();
        Alert::success('Success', 'Deleted successfully  !');
        return redirect()->route('admin.tags.index');
    } // end delete function


}
