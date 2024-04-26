<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use App\Events\UserRegistered;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;

class SignUpAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'name' => 'required|string|max:250',
                'email' => 'required|string|email|max:250|unique:users,email',
                'password' => 'required|string|min:8'
        ];
    }

    public function signUp() : array
    {
        $userData = $this->validated();
        $userData['password'] = Hash::make($this->password);
        $user = User::create($userData);

        Mail::to($user->email)->send(new WelcomeEmail($user));

        return [$user->createToken($this->email)->accessToken, $user];//token, user
    }
}
