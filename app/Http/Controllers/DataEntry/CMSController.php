<?php

namespace App\Http\Controllers\DataEntry;

use App\Helpers\LoggerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCmsRequest;
use App\Http\Requests\Admin\UpdateCmsRequest;
use App\Models\Admin\Cms;
use App\Models\Admin\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class CMSController extends Controller
{
    private $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
    }

    //
    public function index(Request $request)
    {
        $query = Cms::withTrashed();

        // Filter by service name if provided
        if ($request->has('name') && $request->name !== null) {
            $query->whereHas('translations', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }
        $cms = $query->paginate(10);

        return view('data_entry.cms.index' , ['cms'=> $cms , 'langs'=> $this->langs]);

    }

    public function create()
    {
        return view('data_entry.cms.add' , ['langs' => $this->langs]);

    }

    public function store(StoreCmsRequest $request)
    {

        try{

            $image_name ='';
            if($request->has('image')){
                $image_name = time() . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/images/cms'), $image_name);
            }


            DB::beginTransaction();
            $cms = Cms::create([
                'status'=>'active',
                'image' => $image_name
            ]);

            foreach ($this->langs as $lang) {
                $cms->{'alt_image:'.$lang->code}  = $request->alt_image[$lang->code];
                $cms->{'name:'.$lang->code}  = $request->title[$lang->code];
                $cms->{'slug:'.$lang->code}  = $request->slug[$lang->code];
                $cms->{'title_image:'.$lang->code}  = $request->title_image[$lang->code];
                $cms->{'des:'.$lang->code}  = $request->des[$lang->code];
                $cms->{'small_des:'.$lang->code}  = $request->small_des[$lang->code];
                $cms->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $cms->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
            }
            $cms->save();
            LoggerHelper::logAction('create', $cms, $cms->toArray());
            DB::commit();
            
            Alert::success('Success', 'Your Post saved !');
            return redirect()->route('data_entry.cms.index');

        }catch(\Exception $e){
            dd($e->getMessage() , $e->getLine());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('data_entry.cms.index');
        }

    }

    public function edit($id){
        try{
            return view('data_entry.cms.update' , ['blog'=> Cms::findOrFail($id) , 'langs'=> $this->langs]);

        }catch(\Exception $e){
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('data_entry.cms.index');
        }
    }

    public function update(UpdateCmsRequest $request , $id)
    {

        try{
            DB::beginTransaction();
            $cms = Cms::findOrFail($id);
            if ($request->has('image')) {
                $image_name = time() . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/images/cms'), $image_name);
                if ($cms->image && file_exists(public_path('uploads/images/cms/' . $cms->image))) {
                    unlink(public_path('uploads/images/cms/' . $cms->image));
                }
                $cms->image = $image_name;
            }

            foreach ($this->langs as $lang) {
                $cms->{'alt_image:' . $lang->code} = $request->alt_image[$lang->code];
                $cms->{'name:' . $lang->code} = $request->title[$lang->code];
                $cms->{'slug:' . $lang->code} = $request->slug[$lang->code];
                $cms->{'title_image:' . $lang->code} = $request->title_image[$lang->code];
                $cms->{'des:' . $lang->code} = $request->des[$lang->code];
                $cms->{'small_des:'.$lang->code}  = $request->small_des[$lang->code];
                $cms->{'meta_title:' . $lang->code} = $request->meta_title[$lang->code];
                $cms->{'meta_des:' . $lang->code} = $request->meta_des[$lang->code];
            }
            $cms->updated_at = now();
            $cms->save();
            LoggerHelper::logAction('update', $cms, $cms->toArray());
            DB::commit();
            Alert::success('Success', 'Your Article updated successfully!');
            return redirect()->route('data_entry.cms.index');


        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }

    }

    public function destroy($id)
    {
        $cms = Cms::findOrFail($id);
        $cms->forceDelete();
        LoggerHelper::logAction('delete', $cms, $cms->toArray());

        Alert::success('success', 'CMS Deleted Successfully !');
        return redirect()->route('data_entry.cms.index');
    }

    public function soft_delete($id)
    {
        $cms = Cms::findOrFail($id);
        $cms->delete();
        LoggerHelper::logAction('soft_delete', $cms, $cms->toArray());

        Alert::success('success', 'CMS Soft Deleted Successfully !');
        return redirect()->route('data_entry.cms.index');
    }

    public function restore($id)
    {
        $cms = Cms::withTrashed()->findOrFail($id);
        $cms->restore();
        LoggerHelper::logAction('restore', $cms, $cms->toArray());
        Alert::success('success', 'CMS Restored Successfully !');
        return redirect()->route('data_entry.cms.index');

    }
}
