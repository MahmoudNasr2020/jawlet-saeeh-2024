<?php

namespace App\Http\Trait;

trait ApiTrait
{
    public function response($data=null,$msg=null,$status=null)
    {
        return response()->json([
            'data'      =>   $data,
            'message'   =>   $msg,
        ],$status);
    }
}
