<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Des;
use Illuminate\Http\Request;
use App\Http\Resources\DescriptionResource;
use App\Trait\ResponseTrait;
class DescriptionController extends Controller
{

    use ResponseTrait;
    public function get(){

        $des = Des::whereHas('translations', function ($query) {
            $query->where('locale', '=', app()->getLocale());
        })->get();
        return  $this->res(true ,'All Descriptions' , 200 ,DescriptionResource::collection($des));
    }
}
