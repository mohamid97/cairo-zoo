<?php

namespace App\Http\Controllers\DataEntry;

use App\Helpers\LoggerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutRequest;
use App\Models\Admin\About;
use App\Models\Admin\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AboutController extends Controller
{
    protected $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
    }
    // index for about
    public function index()
    {
        $about = About::first();
        return view('data_entry.about.index' ,['about'=> $about , 'langs' => $this->langs ]);
    }
    public function update(AboutRequest $request)
    {


        try{
            DB::beginTransaction();
            $about = About::first() ?? new About();
            if($request->has('photo')){
                $image_name = $request->photo->getClientOriginalName();
                $request->photo->move(public_path('uploads/images/about'), $image_name);
                if (isset($about->photo) && file_exists(public_path('uploads/images/about/' .$about->photo))) {
                    unlink(public_path('uploads/images/about/' .$about->photo));
                }
                $about->photo = $image_name;
            }
            $about->phone = $request->phone;
            // loop for about  translation
            foreach ($this->langs as $lang) {
                $about->{'name:'.$lang->code}         = $request->name[$lang->code];
                $about->{'des:'.$lang->code}          = $request->des[$lang->code];
                $about->{'meta_title:'.$lang->code}   = $request->meta_title[$lang->code];
                $about->{'meta_des:'.$lang->code}     = $request->meta_des[$lang->code];
                $about->{'title_image:'.$lang->code}  = $request->title_image[$lang->code];
                $about->{'alt_image:'.$lang->code}    = $request->alt_image[$lang->code];
            }


            $about->save();
            LoggerHelper::logAction('update', $about, $about->toArray());
            // commit transaction
            DB::commit();
            Alert::success('Success', 'Updated Successfully ! !');
            return redirect()->back();

        }catch(\Exception $e){

            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('data_entry.about.index');
        }// end catach


    } // end update function
}
