<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Trait\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiTrait;
    public function updateDeviceToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);

        $user = Auth::guard('api')->user();
        $user->device_token = $request->input('device_token');
        $user->save();

        return $this->response('Device token updated successfully',200);
        //return response()->json(['message' => 'Device token updated successfully']);
    }


    public function deleteAccount(Request $request)
    {

         $user = Auth::guard('api')->user();

        if ($user) {
            //$user->delete();
            return $this->response('','Account deleted successfully', 200);
        }

        return $this->response('','User not found', 404);
    }
}
