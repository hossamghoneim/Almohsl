<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BigTrackerResource extends JsonResource
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
            "vehicle_manufacturer" => $this->vehicle_manufacturer,
            "vehicle_model" => $this->vehicle_model,
            "traffic_structure" => $this->traffic_structure,
            "color" => $this->color,
            "model_year" => $this->model_year,
            "username" => $this->username,
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
            "employer" => $this->employer,
        ];
    }
}
