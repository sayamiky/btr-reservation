<?php

namespace App\Http\Resources\Reservation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferReservationResource extends JsonResource
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
            'reservation_code' => $this->reservation_code,
            'driver_id' => $this->driver_id,
            'driver_id' => $this->driver,
            'pickup_location' => $this->pickup_location,
            'pickup_time' => $this->pickup_time,
            'dropoff_location' => $this->dropoff_location,
            'dropoff_time' => $this->dropoff_time,
            'distance' => $this->distance,
            'price' => $this->price,
            'note' => $this->note,
        ];
    }
}
