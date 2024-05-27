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
            'invoice_code' => $this->invoice_code,
            'voucher_code' => $this->voucher_code,
            'payment_type' => $this->payment_type,
            'total' => $this->total,
            'guest' => new GuestResource($this->whenLoaded('guest')),
            'transfer' => new TransferReservationResource($this->whenLoaded('transfer'))
        ];
    }
}
