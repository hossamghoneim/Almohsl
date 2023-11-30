<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MiniTrackerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "car_number" => $this->carNumber->number,
            "type" => $this->type,
            "location" => $this->location,
            "district" => $this->district,
            "url" => $this->url,
            "date" => $this->date,
        ];
    }
}
