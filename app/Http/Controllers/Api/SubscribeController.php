<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubscribeRequest;
use App\Models\Admin\Subscribe;
use Illuminate\Http\Request;
use App\Trait\ResponseTrait;

class SubscribeController extends Controller
{
    use ResponseTrait;
    //
    public function store(SubscribeRequest $request){
        $check = Subscribe::where('email' , $request->email)->exist();
        if($check){
            $subsribe = new Subscribe();
            $subsribe->email = $request->email;
            $subsribe->save();
            return $this->res(true , 'Email added Successfully !' , 200);
        }

        return $this->res(false , 'error happend!' , 500);


    } // end store function





}
