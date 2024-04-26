<?php

namespace App\Http\Requests\Admin;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:3',
            'is_visible' => 'nullable|in:1,0',
        ];
    }

    public function storeTag()
    {
        return Tag::create($this->validated());
    }
}
