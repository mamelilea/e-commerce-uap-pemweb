<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'nama',
        'telepon',
        'alamat',
        'kota',
        'kodepos',
        'pengiriman',
        'payment',
        'subtotal',
        'ongkir',
        'total',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
