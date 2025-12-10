<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\Store;
use App\Models\StoreBalanceHistory;

class SyncStoreBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate store balances based on completed transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting balance synchronization...');

        $stores = Store::all();

        foreach ($stores as $store) {
            $this->info("Processing store: {$store->name}");

            // correct firstOrCreate logic for store balance
            $balance = $store->storeBalance()->firstOrCreate(
                ['store_id' => $store->id],
                [
                    'balance' => 0,
                    'bank_name' => '-', // Default values to avoid null violation if not null-able
                    'bank_account_name' => '-',
                    'bank_account_number' => '-',
                ]
            );

            // Calculate total from completed transactions
            $totalSales = Transaction::where('store_id', $store->id)
                ->where('payment_status', 'completed')
                ->sum('grand_total');
            
            // Calculate total withdrawals (pending + approved) - rejected ones return to balance
            // Wait, logic in WithdrawalController: "Deduct balance immediately". 
            // So if status is pending/approved, money is GONE from balance. 
            // If rejected, money should be returned (incremented).
            // So current ACTUAL balance should be: TotalSales - (Pending+Approved Withdrawals).
            
            // But wait, my manual calculation relies on History?
            // Or I can just reset to TotalSales and then subtract withdrawals.
            
            $withdrawals = \App\Models\Withdrawal::where('store_balance_id', $balance->id)
                ->whereIn('status', ['pending', 'approved'])
                ->sum('amount');

            $calculatedBalance = $totalSales - $withdrawals;

            $this->info("  - Total Sales (Completed): {$totalSales}");
            $this->info("  - Total Withdrawals (Pending/Approved): {$withdrawals}");
            $this->info("  - New Balance: {$calculatedBalance}");

            $balance->update(['balance' => $calculatedBalance]);
        }

        $this->info('Balance synchronization completed successfully.');
    }
}
