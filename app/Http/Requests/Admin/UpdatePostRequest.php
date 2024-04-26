<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;


class UpdatePostRequest extends FormRequest
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
            'title' => 'sometimes|string|max:1000|min:3',
            'description' => 'sometimes|string|max:2000|min:10',
            'is_visible' => 'sometimes|boolean',
            'images' => 'sometimes|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_ids' => 'sometimes|array|exists:categories,id',
        ];
    }

    public function build()
    {
        $this->post->update($this->validated());

        $this->PostImages($this->post, $this->images);

        $this->post->categories()->sync($this->category_ids);

        return $this->post;
    }

    public function PostImages($post, $images)
    {
        if ($this->hasFile('images')) {

            $post->remove();

            foreach ($images as $index => $image) {
                $image = $image->store('uploads', 'public');
                $post->images()->create([
                    'image' => $image,
                    'is_main' => $index == 1 ? 1 : 0
                ]);
            }
        }
    }
}
