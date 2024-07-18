<?php

namespace App\Http\Controllers\Api\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateProfileRequest;
use App\Http\Trait\ApiTrait;
use App\Http\Trait\ImageTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ImageTrait;
    use ApiTrait;
    public function update_profile(UpdateProfileRequest $request)
    {
        $data = $request->all();
        $user = User::find(auth()->guard('api')->user()->id);

        if(!$user)
        {
            return $this->response('','user Not Found',404);
        }

        if($request->hasFile('image'))
        {
            $this->deleteImage($user->getRawOriginal('image'));
            $data['image'] = $this->imageUpload('users',$request->image);
        }

        if ($request->filled('password'))
        {
            $data['password'] = Hash::make($request->input('password'));
        }
        else
        {
            $data['password'] = $user->password;
        }

        $update = $user->update($data);
        if($update)
        {
            $user->makeHidden(['password', 'otp','password_otp','email_verified_at','verify','created_at','updated_at']);
            return $this->response(['user'=>$user],'success',200);
        }
        return $this->response('','error',422);
    }

    public function show_profile()
    {
        $user = Auth::guard('api')->user();
        $user->makeHidden(['password', 'otp','password_otp','email_verified_at','verify','created_at','updated_at']);
        return $this->response(['user'=>$user],'success',200);

    }
}
