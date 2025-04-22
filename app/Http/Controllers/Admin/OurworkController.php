<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateOurWork;
use App\Http\Requests\Admin\EditOurWorkRequest;
use App\Models\Admin\Gallary;
use App\Models\Admin\Lang;
use App\Models\Admin\Ourwork;
use App\Models\Admin\OurworkGallery;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OurworkController extends Controller
{
    private $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
    }

    //
    public function index(Request $request)
    {


        $query = Ourwork::withTrashed();
        if($request->has('search') && !empty($request->search) ){
            $searchTerm = $request->search;
            $query->whereHas('translations', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
        $our_works= $query->paginate(5);

        return view('admin.ourworks.index' , ['our_works'=>$our_works , 'langs'=>$this->langs , 'searchTerm' =>$request->search ?? ''  ]);

    }

    public function edit($id)
    {
        $our_works = Ourwork::findOrFail($id);
        return view('admin.ourworks.update' , ['our_works' => $our_works , 'langs' => $this->langs]);

    }


    public function update(EditOurWorkRequest $request , $id)
    {
        try {

            DB::beginTransaction();
            $image_name = null;
            $icon_name = null;
            $Ourwork = Ourwork::findOrFail($id);
            if($request->has('photo')){
                $image_name = $request->photo->getClientOriginalName();
                $request->photo->move(public_path('uploads/images/ourworks'), $image_name);
                if ($Ourwork->photo != null && file_exists(public_path('uploads/images/ourworks/' .$Ourwork->photo))) {
                    unlink(public_path('uploads/images/ourworks/' .$Ourwork->photo));
                }

            }


            if($request->has('icon')){
                $icon_name = $request->icon->getClientOriginalName();
                $request->icon->move(public_path('uploads/images/ourworks'), $icon_name);
                if ($Ourwork->icon != null && file_exists(public_path('uploads/images/ourworks/' .$Ourwork->icon))) {
                    unlink(public_path('uploads/images/ourworks/' .$Ourwork->icon));
                }

            }



            $Ourwork->update([
                'photo'     => ( $image_name != null) ? $image_name : $Ourwork->photo,
                'icon'      => ( $icon_name != null) ? $icon_name : $Ourwork->icon,
                'link'      => $request->link,
            ]);

            foreach ($this->langs as $lang) {
                $Ourwork->{'name:'.$lang->code}  = $request->name[$lang->code];
                $Ourwork->{'des:'.$lang->code}  = $request->des[$lang->code];
                $Ourwork->{'title_image:'.$lang->code}  = $request->title_image[$lang->code];
                $Ourwork->{'alt_image:'.$lang->code}  = $request->alt_image[$lang->code];
                $Ourwork->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $Ourwork->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];

            }

            $Ourwork->save();
            DB::commit();
            Alert::success('success', 'Our Work  Updated Successfully !');
            return redirect()->route('admin.our_works.index');

        }catch (\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.our_works.index');
        }

    } // end update our works


    public function create()
    {
        return view('admin.ourworks.add' , ['langs'=>$this->langs]);

    }

    public function store(CreateOurWork $request)
    {

        try {
            DB::beginTransaction();
            $icon_name= null;
            $image_name = null;
            if($request->has('icon')){
                $icon_name = $request->icon->getClientOriginalName();
                $request->icon->move(public_path('uploads/images/ourworks'), $icon_name);
            }
            if($request->has('photo')){
                $image_name = $request->photo->getClientOriginalName();
                $request->photo->move(public_path('uploads/images/ourworks'), $image_name);
            }

            $ourwork = new Ourwork();
            $ourwork->icon = $icon_name;
            $ourwork->photo = $image_name;
            $ourwork->link = $request->link;
            foreach ($this->langs as $lang) {
                $ourwork->{'name:'.$lang->code}  = $request->name[$lang->code];
                $ourwork->{'des:'.$lang->code}  = $request->des[$lang->code];
                $ourwork->{'title_image:'.$lang->code}  = $request->title_image[$lang->code];
                $ourwork->{'alt_image:'.$lang->code}  = $request->alt_image[$lang->code];
                $ourwork->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $ourwork->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];

            }
            $ourwork->save();
            DB::commit();
            Alert::success('Success', 'Our Work Updated Successfully ! !');
            return redirect()->route('admin.our_works.index');
        }catch(\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.our_works.index');
        }


    }


    public function destroy($id)
    {
        $our_work = Ourwork::findOrFail($id);
        $our_work->forceDelete();
        Alert::success('success', 'Our Work Deleted Successfully !');
        return redirect()->route('admin.our_works.index');
    }

    public function soft_delete($id)
    {
        $our_work = Ourwork::findOrFail($id);
        $our_work->delete();
        Alert::success('success', 'Our Work Soft Deleted Successfully !');
        return redirect()->route('admin.our_works.index');

    }

    public function restore($id)
    {
        $our_work = Ourwork::withTrashed()->findOrFail($id);
        $our_work->restore();
        Alert::success('success', 'Our Works Restored Successfully !');
        return redirect()->route('admin.our_works.index');

    }



    public function gallery($id){
        $our_work = Ourwork::with('gallery')->findOrFail($id);
        return view('admin.ourworks.Gallary' , ['our_work'=>$our_work]);
    }


    public function delete_gallery($id){

        try {
            DB::beginTransaction();
            $gallery = OurworkGallery::findOrFail($id);
            if (isset($gallery->photo) &&file_exists(public_path('uploads/images/ourworks/' .$gallery->photo))) {
                unlink(public_path('uploads/images/ourworks/' .$gallery->photo));
            }
            $gallery->delete();
            DB::commit();
            Alert::success('Success', 'Our Work Gallery Added Successfully !');
            return redirect()->back();

        }catch (\Exception $e){
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.our_works.index');
        }

    }


    public function store_gallery(Request $request, $id)
    {
        $our_work = Ourwork::findOrFail($id);

        // Validate multiple images
        $request->validate([
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);


        // Check if the request has files
        if ($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                $image_name = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('uploads/images/ourworks/'), $image_name);

                // Save each image in the gallery table
                $gallery = new OurworkGallery();
                $gallery->our_work_id = $our_work->id;
                $gallery->photo = $image_name;
                $gallery->save();
            }

            Alert::success('Success', 'Our Work Gallery Added Successfully!');
            return redirect()->back();
        }

        Alert::error('Error', 'No files uploaded. Please try again.');
        return redirect()->back();
    }








}
