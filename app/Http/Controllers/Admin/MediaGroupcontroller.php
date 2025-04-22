<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MediaGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MediaGroupcontroller extends Controller
{
    public function index() {

        $media = MediaGroup::withTrashed()->get();

        return view('admin.media.group_media.index' , ['medias'=>$media]);
        
    }

    public function create(){
        return view('admin.media.group_media.create');
    }

    public function edit($id){
        $media = MediaGroup::findOrFail($id);
        return view('admin.media.group_media.update' , ['media'=>$media]);
    }

    public function store(Request $request) {

        try{
            DB::beginTransaction();
            $media = new MediaGroup();
            $media->name = $request->name;
            $media->save();
            DB::commit();
            Alert::success('Success', 'Created Successfully ! !');
            return redirect()->route('admin.group_media.index');
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage() , $e->getLine());
            Alert::error('error', 'Erorr Ocuired !');
            return redirect()->route('admin.group_media.index');

        }
        
    }





    public function destroy($id){
        $media = MediaGroup::findOrFail($id);
        $media->forceDelete();
        Alert::success('success', 'MediaGroup Deleted Successfully !');
        return redirect()->route('admin.group_media.index');
    }

    public function soft_delete($id)
    {
        $media = MediaGroup::findOrFail($id);
        $media->delete();
        Alert::success('success', 'MediaGroup Soft Deleted Successfully !');
        return redirect()->route('admin.group_media.index');

    }

    public function restore($id)
    {
        $media = MediaGroup::withTrashed()->findOrFail($id);
        $media->restore();
        Alert::success('success', 'MediaGroup Restored Successfully !');
        return redirect()->route('admin.group_media.index');

    }


    public function update(Request $request , $id)
        {

            try{
                DB::beginTransaction();
                $media = MediaGroup::findOrFail($id);
                $media->name = $request->name;
                $media->save();
                DB::commit();
                Alert::success('Success', 'Updated Successfully ! !');
                return redirect()->route('admin.group_media.index');
            }catch(\Exception $e){
                DB::rollBack();
                Alert::error('error', 'Erorr Ocuired !');
                return redirect()->route('admin.group_media.index');
    
            }
            
        }



        // get all files of media group 

        public function show_files($id){

          $media = MediaGroup::with(['gallerys' , 'files' , 'viedos'])->findOrFail($id);
          return view('admin.media.group_media.all_media' , ['media'=>$media]);


        }
        




}
