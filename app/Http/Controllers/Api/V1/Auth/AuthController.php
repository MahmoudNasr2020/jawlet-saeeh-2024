<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Trait\ApiTrait;
use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiTrait;


    public function register(RegisterRequest $request)
    {
        $userData = $request->validated();

        $userData['password'] = Hash::make($userData['password']);

        $otp = strval(rand(100000, 999999));

        $userData['otp'] = $otp;

        $user = User::create($userData);

        $user->token = null;
        Mail::to($user->email)->send(new SendOtpMail($otp));

        return $this->response([
            'user'=>$user,
        ],'Registration has been completed successfully. Please check your email to activate the account.',201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => 'required',
        ]);

        $token = Auth::guard('api')->attempt(['email'=>$request->email,'password'=>$request->password]);
        if ($token && Auth::guard('api')->user()->verify == 1)
        {
            $user = Auth::guard('api')->user();
            $user->token = $token;
            return $this->response([
                'user'=>$user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ], 'success', 200);
        }

        return $this->response('','Unauthorized',401);

    }

    //check otp for verify account
    public function checkOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->otp === $request->otp)
        {
            $user->update(['verify'=>1]);

            $token = Auth::guard('api')->login($user);

            //$token = $user->createToken('MyApp')->plainTextToken;

            $user->token = $token;
            return $this->response([
                'user'=>$user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ], 'The account has been activated and logged in successfully.', 200);
        }
        else
        {
            return $this->response('','The verification code is invalid',400);
        }
    }

    public function resend_otp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if($user)
        {
            $user->token = null;
            Mail::to($user->email)->send(new SendOtpMail($user->otp));
            return $this->response(['user'=>$user],'The activation code has been sent to your email',200);
        }

        return $this->response('','This user does not exist',404);
    }


    public function forget_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
        $user = User::where('email', $request->email)->first();
        if($user)
        {
            $otp = strval(rand(100000, 999999));
            $user->update([
               'password_otp' => $otp
            ]);

            $user->token = null;
            Mail::to($user->email)->send(new SendOtpMail($otp));
            return $this->response(['user'=>$user],'The activation code has been sent to your email',200);
        }

        return $this->response('','This user does not exist',404);
    }

    public function confirm_forget_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email',$request->email )->first();

        if ($user->password_otp === $request->otp)
        {
            //$token = $user->createToken('MyApp')->plainTextToken;
            $user->token = null;
            return $this->response(['user'=>$user], 'The verification code is valid', 200);
        }

        return $this->response('','The verification code is invalid',422);
    }


    public function resend_password_otp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if($user)
        {
            $user->token = null;
            Mail::to($user->email)->send(new SendOtpMail($user->password_otp));
            return $this->response(['user'=>$user],'The activation code has been sent to your email',200);
        }

        return $this->response('','This user does not exist',404);
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email',$request->email )->first();

        if ($user)
        {
            $password = Hash::make($request->password);
            $user->update([
                'password' => $password,
                'password_otp' => null
            ]);
            $user->token = null;
            return $this->response(['user'=>$user], 'The password has been changed successfully', 200);
        }

        return $this->response('','This user does not exist',404);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->response('','Successfully logged out',200);
    }

}
