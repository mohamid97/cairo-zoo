<?php

namespace App\Trait;

trait ResponseTrait
{
    public function res($status = true, $msg = null ,$code = 200 , $data = null)
    {
        return response()->json([
            'status'=>$status,
            'code'=>$code,
            'msg' => $msg,
            'data'=>$data
        ]);

    }

}
