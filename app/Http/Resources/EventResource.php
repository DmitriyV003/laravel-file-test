<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'text' => $this->resource->text,
            'created_by' => $this->whenLoaded('creator', function ($cr) {
                return $cr->id;
            }),
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
