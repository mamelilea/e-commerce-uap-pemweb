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
        'verified_by',
        'verified_at',
        'rejection_reason',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
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

    // Query Scopes
    public function scopePending($query)
    {
        return $query->where('is_verified', false)
            ->whereNull('rejection_reason');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeRejected($query)
    {
        return $query->whereNotNull('rejection_reason');
    }

    // Helper Methods
    public function isPending()
    {
        return !$this->is_verified && is_null($this->rejection_reason);
    }

    public function isVerified()
    {
        return $this->is_verified;
    }

    public function isRejected()
    {
        return !is_null($this->rejection_reason);
    }
}
