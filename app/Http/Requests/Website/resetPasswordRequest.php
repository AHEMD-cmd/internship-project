<?php

namespace App\Http\Requests\Website;

use App\Mail\ResetPasswordSuccessEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Http\FormRequest;

class resetPasswordRequest extends FormRequest
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
            'password' => 'required|string|max:255|min:8|confirmed'
        ];
    }

    public function resetPassword()
    {
        $user = User::where('reset_password_token', $this->header('X-token'))->first();
        if ($user) {
            $user->password = Hash::make($this->password);
            $user->reset_password_token = null;
            $user->save();

            Mail::to($user->email)->send(new ResetPasswordSuccessEmail());

            return true;
        }
        return false;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if (!$this->header('X-token')) {
                $validator->errors()->add('wronge_credentials', __('auth.token_required'));
            }
        });
    }
}
