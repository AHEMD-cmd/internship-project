<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\SignInAuthRequest;
use App\Http\Requests\Admin\SignUpAuthRequest;
use App\Http\Requests\Admin\RegisterAuthRequest;

class AuthController extends Controller
{
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
        return response([
            'user' => Auth::user()
        ]);
    }

    public function signOut()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => __('auth.logout')
        ]);
    }
}
