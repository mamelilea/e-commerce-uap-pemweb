<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    protected $fillable = [
        'store_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2' // FIX: Typo dari 'balanace' → 'balance'
    ];

    // Relationships
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function storeBalanceHistories()
    {
        return $this->hasMany(StoreBalanceHistory::class);
    }

    // Alias untuk compatibility dengan view
    public function histories()
    {
        return $this->hasMany(StoreBalanceHistory::class)->orderBy('created_at', 'desc');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    // Helper Methods
    public function addIncome($amount, $referenceId, $referenceType, $remarks)
    {
        $this->balance += $amount;
        $this->save();

        // Create history record
        StoreBalanceHistory::create([
            'store_balance_id' => $this->id,
            'type' => 'income',
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'amount' => $amount,
            'remarks' => $remarks,
        ]);

        return $this;
    }

    public function withdraw($amount, $referenceId, $referenceType, $remarks)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Saldo tidak mencukupi');
        }

        $this->balance -= $amount;
        $this->save();

        // Create history record
        StoreBalanceHistory::create([
            'store_balance_id' => $this->id,
            'type' => 'withdraw',
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'amount' => $amount,
            'remarks' => $remarks,
        ]);

        return $this;
    }

    // Accessor: Format balance to Rupiah
    public function getFormattedBalanceAttribute()
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }
}
