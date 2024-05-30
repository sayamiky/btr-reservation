<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'drivers';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'venichle_type',
        'license_plate',
        'status',
    ];

    function transfer()
    {
        return $this->hasMany(TransferReservation::class);
    }
}
