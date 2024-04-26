<?php

namespace App\Http\Requests\Admin;

use App\Models\Specification;
use Illuminate\Foundation\Http\FormRequest;

class StoreSpecificationRequest extends FormRequest
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

    public function storeSpecification()
    {
        $specification = Specification::create($this->validated());

        $this->specificationImage($specification, $this->image);

        return $specification;
    }

    public function specificationImage($specification, $image)
    {
            $image = $image->store('uploads', 'public');

            $specification->image()->create([
                'image' => $image,
                'is_main' => 1
            ]);
    }
}
