<?php
namespace App\Http\Resources\Reservation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reservation_code' => $this->reservation_code,
            'reservation_date' => $this->reservation_date,
            'guest_name' => $this->guest->name,
            'guest_phone' => $this->guest->phone,
            'guest_email' => $this->guest->email,
            'driver_name' => $this->transfer->driver->name,
            'driver_phone' => $this->transfer->driver->phone,
            'driver_email' => $this->transfer->driver->email,
            'pickup_location' => $this->transfer->pickup_location,
            'pickup_time' => $this->transfer->pickup_time,
            'dropoff_location' => $this->transfer->dropoff_location,
            'dropoff_time' => $this->transfer->dropoff_time,
            'payment_type' => $this->payment_type,
            'status' => $this->status,
        ];
    }
}
