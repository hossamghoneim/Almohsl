<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchedCarResource extends JsonResource
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
            "car_number" => $this->car_number,
            "username" => trim($this->username),
            "type" => $this->type,
            "lat" => $this->lat,
            "lng" => $this->lng,
            "district" => $this->district,
            "location" => $this->location,
            "url" => $this->url,
            "vehicle_manufacturer" => $this->vehicle_manufacturer,
            "vehicle_model" => $this->vehicle_model,
            "traffic_structure" => $this->traffic_structure,
            "source" => $this->source,
            "color" => $this->color,
            "model_year" => $this->model_year,
            "board_registration_type" => $this->board_registration_type,
            "user_identity" => $this->user_identity,
            "contract_number" => $this->contract_number,
            "cic" => $this->cic,
            "certificate_status" => $this->certificate_status,
            "vehicles_count" => $this->vehicles_count,
            "product" => $this->product,
            "installments_count" => $this->installments_count,
            "late_days_count" => $this->late_days_count,
            "city" => $this->city,
            "employer" => trim($this->employer),
            "date" => $this->created_at->format("Y-m-d"),
        ];
    }
}
