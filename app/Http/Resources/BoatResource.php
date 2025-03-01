<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoatResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'is_new' => (bool) $this->is_new,
            'description' => $this->description,
            'boat_type' => $this->boat_type,
            'engine_number' => $this->engine_number,
            'price' => (int) $this->price,
            'year' => (int) $this->year,
            'length' => (float) $this->length,
            'model' => $this->boat_model?->name,
            'manufacturer' => $this->boat_model?->manufacturer?->name,
            'location' => [
                'city' => $this->location?->city,
                'country' => $this->location?->country,
                'country_code' => $this->location?->country_code,
            ],
            'main_image' => $this->mainImage?->path,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
