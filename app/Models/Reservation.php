<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "products";
    protected $fillable = [
        'reservation_code',
        'reservation_date',
        'invoice_code',
        'voucher_code',
        'payment_type',
        'total',
        'status',
        'partner_id',
    ];

    function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    function detail()
    {
        return $this->hasMany(DetailReservation::class);
    }

    function guest()
    {
        return $this->hasOne(Guest::class);
    }

    function transfer()
    {
        return $this->hasOne(TransferReservation::class);
    }
}
