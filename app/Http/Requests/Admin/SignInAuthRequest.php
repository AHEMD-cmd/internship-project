<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class SignInAuthRequest extends FormRequest
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
            'email' => 'required|string|email|exists:users,email|max:60',
            'password' => 'required|string|max:100'
        ];
    }

    public function signIn()
    {
        $user = User::where('email', $this->email)->first();

        if ($user  && Hash::check($this->password, $user->password)) {
            return [$user->createToken($this->email)->accessToken, $user];
        }

        return false;
    }
}
