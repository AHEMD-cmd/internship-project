<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use App\Http\Resources\Admin\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => new ImageResource($this->main_image),
        ];
    }
}
