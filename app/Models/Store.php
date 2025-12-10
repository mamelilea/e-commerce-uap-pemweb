<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'about',
        'phone',
        'address_id',
        'city',
        'address',
        'postal_code',
        'is_verified',
    ];

    // relationships one store has one owner (user)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function storeBallance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function withdrawals()
    {
        // rekening bank disimpan di sini
        return $this->hasMany(Withdrawal::class, 'store_balance_id', 'id')
            ->withDefault();
    }

    public function balance()
    {
        // model StoreBalance harus ada di App\Models\StoreBalance,
        return $this->hasOne(StoreBalance::class, 'store_id', 'id');
    }
}
