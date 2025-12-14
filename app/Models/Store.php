<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\StoreBalance;
use App\Models\Product;
use App\Models\Transaction;

class Store extends Model
{

    use HasFactory;

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
        'bank_name',
        'bank_account_number',
        'bank_account_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storeBalance()
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
}
