<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReservation extends Model
{
    use HasFactory;

    protected $table = 'detail_reservations';
    protected $fillable = [
        'reservation_code',
        'product_id',
        'pax_type',
        'price',
        'discount',
        'qty',
        'total',
    ];

    function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_code', 'reservation_code');
    }
    function product()
    {
        return $this->belongsTo(Product::class);
    }
}
