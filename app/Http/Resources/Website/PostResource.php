<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use App\Http\Resources\Website\UserResource;
use App\Http\Resources\Website\ImageResource;
use App\Http\Resources\Website\CommentResource;
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
            'description' => $this->description,
            'image' => $this->image,
            // 'comments' => $this->whenLoaded('comments', function () {
            //     return CommentResource::collection(
            //         $this->comments->paginate(10)
            //     );
            // }),
            'user' => new UserResource($this->user),
            'images' => ImageResource::collection($this->images),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

