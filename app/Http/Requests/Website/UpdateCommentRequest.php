<?php

namespace App\Http\Requests\Website;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
			'body' => 'required|string',
		];
	}

	public function updateComment()
	{
		$this->comment->update($this->validated());

		return $this->comment;
	}

     // check if the comment is related to the post
     public function commentRelationWithPost($validator)
     {
         if ($this->comment->post_id != $this->post->id) {
             $validator->errors()->add('comment.error',  __('comment.does_not_belong'));
         }
     }

     public function withValidator($validator)
     {
         $validator->after(function ($validator) {
             $this->commentRelationWithPost($validator);
         });
     }
}
