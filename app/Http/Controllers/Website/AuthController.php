<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ForgetPasswordRequest;
use App\Http\Requests\Website\resetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Website\SignInAuthRequest;
use App\Http\Requests\Website\SignUpAuthRequest;

class AuthController extends Controller
{

    public function signUp(SignUpAuthRequest $request)
    {
        $userData = $request->signUp();
        return response([
            'message' => __('auth.register'),
            'token' => $userData[0],
            'user' =>  $userData[1]
        ]);
    }

    public function signIn(SignInAuthRequest $request)
    {
        $userData = $request->signIn();

        if ($userData) {
            return response([
                'message' => __('auth.login'),
                'token' => $userData[0],
                'user' =>  $userData[1]
            ]);
        }

        return response([
            'message' => __('auth.wronge_credentials'),
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return response([
            'user' => $user
        ]);
    }

    public function signOut()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => __('auth.logout')
        ]);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $request->forgetPassword();
        return response([
            'message' => __('auth.may_send_email')
        ]);
    }

    public function resetPassword(resetPasswordRequest $request)
    {
        $condition = $request->resetPassword();
        return response([
            'message' => $condition ? __('auth.done_successfully') : __('auth.failed')
        ], $condition ? 200 : 400);
    }
}
