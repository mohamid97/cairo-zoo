<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OffersResource;
use App\Models\Admin\Offers;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    //
    use ResponseTrait;
    public function get(){
            // Eager load the product relationship
            $offers = Offers::with('product')->get();
            return $this->res(true , 'All Offers' , 200  ,  OffersResource::collection($offers));
    }
}
