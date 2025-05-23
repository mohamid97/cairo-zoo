<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Lang;
use App\Models\Admin\Service;
use App\Models\Admin\ServicesGallary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceController extends Controller
{


    private $langs;

    // service constructor
    public function __construct()
    {
        $this->langs = Lang::all();
    }


    // return index page
    public function index(Request $request)
    {
        $query = Service::with('gallery')->withTrashed();

        // Filter by service name if provided
        if ($request->has('name') && $request->name !== null) {
            $query->whereHas('translations', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $services = $query->paginate(10);
        return view('admin.services.index', ['services' => $services, 'langs' => $this->langs]);
    }


    // return create page
    public function create()
    {
        $categories = Category::all();
        return view('admin.services.add' , ['langs'=> $this->langs , 'categories'=>$categories]);

    }

    // store service
    public function store(StoreServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $image_name = null;
            if ($request->hasFile('image')) {
                  $image_name = time() .'.'.$request->image->getClientOriginalName();
                  $request->image->move(public_path('uploads/images/service'), $image_name);
            }
            // insert service
             $service = new Service();
             $service->price = $request->price;
             $service->category_id = ($request->category != '0' ) ? $request->category : null;
             $service->star = $request->star;
             $service->image = $image_name;
             $service->save();
            foreach ($this->langs as $lang) {
                $service->{'name:'.$lang->code}  = $request->name[$lang->code];
                $service->{'des:'.$lang->code}  = $request->des[$lang->code];
                $service->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $service->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $service->{'small_des:'.$lang->code}  = $request->small_des[$lang->code];
                $service->{'slug:'.$lang->code}  = $request->slug[$lang->code];
                $service->{'alt_image:'.$lang->code}  = $request->alt_image[$lang->code];
                $service->{'title_image:'.$lang->code}  = $request->title_image[$lang->code];
            }
            $service->save();
            DB::commit();
            Alert::success('Success', 'Created Successfully ! !');
            return redirect()->back();
        }catch (\Exception $e){
            dd($e->getMessage() , $e->getLine());
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.services.index');
        }

    }


    // destroy
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->forceDelete();
        Alert::success('success', 'Service Deleted Successfully !');
        return redirect()->back();
    }

    // soft delete
    public function soft_delete($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        Alert::success('success', 'ServiceSoft Deleted Successfully !');
        return redirect()->back();

    }

    // restore service
    public function restore($id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        $service->restore();
        Alert::success('success', 'Service Restored Successfully !');
        return redirect()->back();

    }


    // edit service
    public function edit($id)
    {
        $service = Service::with('gallery')->findOrFail($id);
        $categories = Category::all();
        return view('admin.services.update' , ['service'=>$service , 'langs'=>$this->langs ,'categories'=>$categories]);

    }


    // update service
    public function update(UpdateServiceRequest $request , $id)
    {

        try {
            DB::beginTransaction();
            $service = Service::with('gallery')->findOrFail($id);

            $image_name = null;
            if ($request->hasFile('image')){
                $image_name = time() .'.'.$request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/images/service'), $image_name);
            }

            $service->star = $request->star;
            $service->category_id = ($request->category != 'null' ) ? $request->category : null;

            $service->price = $request->price;
            if(isset($image_name) && $image_name != null){
                 $service->image = $image_name;
            }


            // insert translation of services
            foreach ($this->langs as $lang) {
                $service->{'name:'.$lang->code}  = $request->name[$lang->code];
                $service->{'des:'.$lang->code}  = $request->des[$lang->code];
                $service->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $service->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $service->{'slug:'.$lang->code}  = $request->slug[$lang->code];
                $service->{'alt_image:'.$lang->code}  = $request->alt_image[$lang->code];
                $service->{'title_image:'.$lang->code}  = $request->title_image[$lang->code];
            }
            $service->save();

            DB::commit();
            Alert::success('Success', 'Updated Successfully ! !');
            return redirect()->back();

        }catch (\Exception $e){
            dd($e->getMessage() , $e->getLine());
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.services.index');
        }


    }



    // return service with its gallery

    public function gallery($id){
        $product = Service::with('gallery')->findOrFail($id);
        return view('admin.services.gallery' , ['service'=>$product]);
    }


    // store image to service gallery one by one
    public function store_gallery(Request $request , $id){
        $service = Service::findOrFail($id);
        $request->validate([
            'photo.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                // Generate a unique name for each image
                $image_name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                // Move the file to the upload directory
                $file->move(public_path('uploads/images/service'), $image_name);
                // Save each image to the database
                $gallery = new ServicesGallary();
                $gallery->service_id = $service->id;
                $gallery->photo = $image_name;
                $gallery->save();
            }
            // Success message
            Alert::success('Success', 'Service Gallery Added Successfully!');
            return redirect()->back();
        }

        // Error message if no images are uploaded
        Alert::error('Error', 'No images uploaded. Please try again.');
        return redirect()->route('admin.services.index');
    } // end store gallery

    // delete gallery image one by one
    public function delete_gallery($id){

        try {
            DB::beginTransaction();
            $gallery = ServicesGallary::findOrFail($id);
            if (isset($gallery->photo) &&file_exists(public_path('uploads/images/service/' .$gallery->photo))) {
                unlink(public_path('uploads/images/service/' .$gallery->photo));
            }
            $gallery->delete();
            DB::commit();
            Alert::success('Success', 'service Gallery Added Successfully !');
            return redirect()->back();
        }catch (\Exception $e){
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.services.index');
        }

    }




}
