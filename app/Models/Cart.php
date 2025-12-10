<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalItems()
    {
        return $this->cartItems()->sum('quantity');
    }

    public function getSubtotal()
    {
        return $this->cartItems->sum(function ($item) {
        return $item->price * $item->quantity;
    });
    }
}