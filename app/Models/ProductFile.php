<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_files';
    protected $fillable = [
        'product_id',
        'file'
    ];

    function product() {
        return $this->belongsTo(Product::class);
    }
}
