<?php

namespace App\Http\Controllers\Api;

use  App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PagesResource;
use App\Http\Resources\Admin\PagesResourceDetails;
use App\Models\Admin\Page;
use Illuminate\Http\Request;
use App\Trait\ResponseTrait;

class PageController extends Controller
{
    use ResponseTrait;
    //
    public function get(){

        $pages = Page::all();
        return $this->res(true , 'All Pages' , 200 , PagesResource::collection($pages));

    }

    public function details(Request $request){
        $slug = $request->slug;
        if(isset($slug)){
            $page = Page::whereHas('translations' , function ($query) use ($slug){
                $query->where('slug' ,$slug);
            })->first();

            if($page->exists()){
                return $this->res(false , 'No Page' , 200 , new PagesResourceDetails($page));
            }

            return $this->res(false , 'No Page' , 404);
        }

        return $this->res(false , 'No Page' , 404);
    }
}
