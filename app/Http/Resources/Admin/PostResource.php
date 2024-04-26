<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Admin\ImageResource;
use App\Http\Resources\Admin\CommentResource;
use App\Http\Resources\Admin\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_visible' => $this->is_visible,
            'user' => new UserResource($this->user),
            'main_image' => new ImageResource($this->main_image),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

