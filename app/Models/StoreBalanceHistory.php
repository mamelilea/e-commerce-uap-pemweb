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
        'remarks',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Relationship
    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class);
    }

    // Get the reference model (polymorphic-like)
    public function getReference()
    {
        // Contoh: jika reference_type = 'transaction', ambil dari Transaction model
        if ($this->reference_type === 'transaction') {
            return Transaction::where('id', $this->reference_id)->first();
        }

        // Tambahkan logic lain sesuai kebutuhan
        return null;
    }

    // Accessor: Format amount to Rupiah
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Accessor: Get badge color based on type
    public function getBadgeColorAttribute()
    {
        return $this->type === 'income' ? 'green' : 'red';
    }

    // Accessor: Get type label in Indonesian
    public function getTypeLabelAttribute()
    {
        return $this->type === 'income' ? 'Pemasukan' : 'Penarikan';
    }
}
