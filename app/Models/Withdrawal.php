<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithDrawal extends Model
{
    protected $table = 'withdrawals';

    protected $fillable = [
        'store_balance_id',
        'amount',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'status',
    ];

    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class, 'store_balance_id');
    }
}