<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoatDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_new' => $this->is_new,
            'description' => $this->description,
            'boat_type' => $this->boat_type,
            'engine_number' => $this->engine_number,
            'price' => $this->price,
            'year' => $this->year,
            'length' => $this->length,
            'model' => $this->boat_model?->name,
            'manufacturer' => $this->boat_model?->manufacturer?->name,
            'location' => [
                'city' => $this->location?->city,
                'country' => $this->location?->country,
                'country_code' => $this->location?->country_code,
                'latitude' => $this->location?->latitude,
                'longitude' => $this->location?->longitude,
            ],
            'engines' => $this->engines,
            'images' => $this->images->pluck('path')->toArray(),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
