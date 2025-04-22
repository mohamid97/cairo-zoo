<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FeaturedProductsResource;
use App\Models\Admin\Featured;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class FeaturedApiController extends Controller
{
    use ResponseTrait;
    public function get(){
        $featured = Featured::with('product.gallery')->get();
        return $this->res(true , 'All Featured Products' , 200 , FeaturedProductsResource::collection($featured));
    }
}
