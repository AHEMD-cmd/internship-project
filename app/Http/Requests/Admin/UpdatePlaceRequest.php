<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaceRequest extends FormRequest
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
            'description' => 'required|string|max:2000|min:10',
            'is_visible' => 'nullable|in:1,0',
            'images' => 'nullable|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tag_ids' => 'required|array|exists:tags,id',
            'specification_ids' => 'required|array|max:5',
            'specification_ids.*.id' => 'required|exists:specifications,id',
            'specification_ids.*.value' => 'required|string|max:255|min:3',
        ];
    }

    public function update()
    {
        $this->place->update($this->validated());

        $this->place->tags()->sync($this->tag_ids);

        foreach ($this->specification_ids as $specification) {

            $this->place->specifications()->attach($specification['id'], ['value' => $specification['value']]);
        }

        return $this->place;
    }

    public function placeImages($place, $images)
    {
        if ($this->hasFile('images')) {

            $place->remove();

            foreach ($images as $index => $image) {
                $image = $image->store('uploads', 'public');
                $place->images()->create([
                    'image' => $image,
                    'is_main' => $index == 1 ? 1 : 0
                ]);
            }
        }
    }
}
