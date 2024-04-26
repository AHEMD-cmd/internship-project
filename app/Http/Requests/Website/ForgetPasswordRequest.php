<?php

namespace App\Http\Requests\Website;

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
            'email' => 'required|string|email',
        ];
    }

    public function forgetPassword()
    {
        $user = User::where('email', $this->email)->first();

        if ($user) {
            $token = Str::random(60);
            $user->reset_password_token = $token;
            $user->save();
            Mail::to($user->email)->send(new ResetPasswordEmail($token));
        }
    }
}
