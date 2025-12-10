<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{

    protected $fillable = [
        'transaction_id',
        'product_id',
        // 'price', // TODO: Uncomment after adding price column to database
        'qty',
        'subtotal',
    ];

    protected $casts = [
        // 'price' => 'decimal:2', // TODO: Uncomment after adding price column to database
        'subtotal' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
