<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
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
            'title' => 'required|string|max:1000|min:3',
            'description' => 'required|string|max:2000|min:10',
            'is_visible' => 'required|in:1,0',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_ids' => 'required|array|exists:categories,id'
        ];
    }

    public function build()
	{
        $postData = $this->validated();

        $postData['slug'] = $postData['title'];

        $postData['user_id'] = Auth::id();

		$post = Post::create($postData);

		$this->PostImages($post, $this->images);

		$post->categories()->attach($this->category_ids);

		return $post;
	}

    public function PostImages($post, $images)
    {
        foreach ($images as $index => $image) {
            $image = $image->store('uploads', 'public');
            $post->images()->create([
                'image' => $image,
                'is_main' => $index == 1 ? 1 : 0
            ]);
        }
    }
}
