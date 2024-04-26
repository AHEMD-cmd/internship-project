<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\Website\PlaceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
            'is_visible' => $this->is_visible,
            'places' => PlaceResource::collection($this->whenloaded('places')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
