<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BrandResource;
use App\Models\Admin\Brand;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ResponseTrait;
    // get all brands
    public function get()
    {
        
        $brands = Brand::whereHas('translations', function ($query) {
            $query->where('locale', '=', app()->getLocale());
        })->orderBy('updated_at' , 'desc')->get();
        return  $this->res(true ,'All Brands ' , 200 ,BrandResource::collection($brands));
    }
}
