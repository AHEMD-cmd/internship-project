<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function storeCategory()
    {
        $categoryData = $this->validated();

        $categoryData['slug'] = $categoryData['name'];

        $category = Category::create($categoryData);

        $this->CategoryImage($category, $this->image);

        return $category;
    }

    public function CategoryImage($category, $image)
    {
        $image = $image->store('uploads', 'public');
        $category->image()->create([
            'image' => $image,
            'is_main' => 1
        ]);
    }
}
