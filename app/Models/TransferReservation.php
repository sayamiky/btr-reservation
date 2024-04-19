<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferReservation extends Model
{
    use HasFactory;

    protected $table = 'transfer_reservations';
    protected $fillable = [
        'reservation_code',
        'driver_id',
        'pickup_location',
        'pickup_time',
        'dropoff_location',
        'dropoff_time',
        'distance',
        'price',
        'note',
    ];

    function reservation() {
        return $this->belongsTo(Reservation::class, 'reservation_code', 'reservation_code');
    }
    function driver() {
        return $this->belongsTo(Driver::class);
    }
}
