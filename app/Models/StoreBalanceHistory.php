<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBalanceHistory extends Model
{

    protected $fillable = [
        'store_balance_id',
        'type',
        'reference_id',
        'reference_type',
        'amount',
        'description',
    ];

    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class);
    }
}
