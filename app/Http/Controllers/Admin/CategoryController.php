<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    protected $langs;
    //

    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoriesQuery = Category::with('parent')->withTrashed();

        if ($search) {
            $categoriesQuery->whereHas('translations', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results
        $categories = $categoriesQuery->paginate(10); // 10 items per page
        return view('admin.category.index', [
            'categories' => $categories,
            'langs' => $this->langs,
            'search' => $search
        ]);
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.category.add' , ['langs' => $this->langs , 'categories' => $categories]);

    }



    public function store(StoreCategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $imageData = [];
            if ($request->hasFile('photo')) {
                $imageData['photo'] = $this->upload_image($request->file('photo'));
            }
            if ($request->hasFile('thumbinal')) {
                $imageData['thumbinal'] = $this->upload_image($request->file('thumbinal'));
            }

            $categry = Category::create([
                'type'       => $request->type,
                'parent_id'  => ($request->type == 1) ? $request->parent_id  : null,
                'photo'      => $imageData['photo'] ?? null,
                'thumbinal'  => $imageData['thumbinal'] ?? null
            ]);
            foreach ($this->langs as $lang) {
                $categry->{'name:'.$lang->code}  = $request->name[$lang->code];
                $categry->{'des:'.$lang->code}  = $request->des[$lang->code];
                $categry->{'small_des:'.$lang->code}  = $request->small_des[$lang->code];
                $categry->{'slug:'.$lang->code}  = $request->slug[$lang->code];
                $categry->{'alt_image:'.$lang->code}  = $request->alt_image[$lang->code];
                $categry->{'title_image:'.$lang->code}  = $request->title_image[$lang->code];
                $categry->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $categry->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
            }
            $categry->save();
            DB::commit();
            Alert::success('Success', __('main.category_added_successfully'));
            return redirect()->route('admin.category.index');
        }catch (\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', __('main.programer_error'));
            return redirect()->route('admin.category.index');
        }
    }

    public function edit($id)
    {
        $cat = Category::findOrFail($id);
        $categories = Category::all();
        return view('admin.category.update' , ['cat' => $cat , 'langs' => $this->langs , 'categories'=>$categories]);

    }

    public function update(UpdateCategoryRequest $request , $id)
    {
       try{
           $cat = Category::findOrFail($id);
           DB::beginTransaction();
           $image_name = null;
           $imageData = [];
           if ($request->hasFile('photo')) {
               $imageData['photo'] = $this->upload_image($request->file('photo'));
           }
           if ($request->hasFile('thumbinal')) {
               $imageData['thumbinal'] = $this->upload_image($request->file('thumbinal'));
           }
           $cat->update([
               'type'=>$request->type,
               'parent_id'=>($request->type == 1) ? $request->parent_id : null,
               'photo'=> $imageData['photo'] ?? $cat->photo,
               'thumbinal'=>$imageData['thumbinal'] ?? $cat->thumbinal
           ]);
           foreach ($this->langs as $lang) {
               $cat->{'name:'.$lang->code}  = $request->name[$lang->code];
               $cat->{'des:'.$lang->code}  = $request->des[$lang->code];
               $cat->{'small_des:'.$lang->code}  = $request->small_des[$lang->code];
               $cat->{'slug:'.$lang->code}  = $request->slug[$lang->code];
               $cat->{'alt_image:'.$lang->code}  = $request->alt_image[$lang->code];
               $cat->{'title_image:'.$lang->code}  = $request->title_image[$lang->code];
               $cat->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
               $cat->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
           }
           $cat->save();
           DB::commit();
           Alert::success('Success', __('main.category_updated_successfully'));
           return redirect()->route('admin.category.index');
       }catch (\Exception $e){
           Alert::error('error', __('main.programer_error'));
           DB::rollBack();
       }

    } // end update category


    private function upload_image($image)
    {
        $image_name = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/images/category'), $image_name);
        return $image_name;
    }




    public function destroy($id)
    {
        $cat = Category::findOrFail($id);
        $cat->forceDelete();
        Alert::success('success', 'Category Deleted Successfully !');
        return redirect()->route('admin.category.index');
    }

    public function soft_delete($id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();
        Alert::success('success', 'Category Soft Deleted Successfully !');
        return redirect()->route('admin.category.index');

    }

    public function restore($id)
    {
        $cat = Category::withTrashed()->findOrFail($id);
        $cat->restore();
        Alert::success('success', 'Category Restored Successfully !');
        return redirect()->route('admin.category.index');

    }
}
