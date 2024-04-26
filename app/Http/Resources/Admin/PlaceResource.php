<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
            'description' => $this->description,
            'is_visible' => $this->is_visible,
            'main_image' => new ImageResource($this->main_image),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'specifications' => SpecificationResource::collection($this->whenLoaded('specifications')),
        ];
    }
}
