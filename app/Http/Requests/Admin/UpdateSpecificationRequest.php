<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecificationRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:3|unique:categories,name,' . $this->specification->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ];
    }

    public function updateSpecification()
    {
        $this->specification->update($this->validated());

        $this->specificationImage($this->specification, $this->image);

        return $this->specification;
    }

    public function specificationImage($specification, $image)
    {
        if ($this->hasFile('image')) {

            $specification->remove();

            $image = $image->store('uploads', 'public');
            $specification->image()->create([
                'image' => $image,
                'is_main' => 1
            ]);
        }
    }
}
