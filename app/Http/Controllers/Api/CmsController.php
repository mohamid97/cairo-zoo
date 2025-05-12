<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CmsDetailsResource;
use App\Http\Resources\Admin\CmsResource;
use App\Models\Admin\Cms;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    use ResponseTrait;
    //

    public function paginate(){
        $cms = Cms::whereHas('translations', function ($query) {
            $query->where('locale', '=', app()->getLocale());
        })->orderBy('updated_at' , 'desc')->paginate(15);
        return  $this->res(true ,'All Products' , 200 , [

            'blogs' => CmsResource::collection($cms),
            'pagination' => [
                'current_page' => $cms->currentPage(),
                'per_page' => $cms->perPage(),
//               'total' => $cms->total(),
                'last_page' => $cms->lastPage(),
                'next_page_url' => $cms->nextPageUrl(),
                'prev_page_url' => $cms->previousPageUrl(),
            ],


        ]);
    }


    // public function get(){


    //     $cms = Cms::whereHas('translations', function ($query) {
    //         $query->where('locale', '=', app()->getLocale());
    //     })->orderBy('updated_at' , 'desc')->get();
    //     return  $this->res(true ,'All Cms Blogs' , 200 , CmsResource::collection($cms));


    // }

    public function get_cms_details(Request $request){
        $cms_details = Cms::whereHas('translations', function ($query) use($request) {
            $query->where('slug' , $request->slug);
        })->first();

        if(optional($cms_details)->exists()){
            return  $this->res(true ,'Article Details' , 200 , new CmsDetailsResource($cms_details));
        }

        return  $this->res(false ,'Article details not found. Maybe there is no data with this slug or no data in this language.' , 404);
    }




    


}
