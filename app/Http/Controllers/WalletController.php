<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserBalance;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display wallet dashboard with balance and transaction history
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get or create user balance
        $userBalance = UserBalance::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );
        
        // Get wallet transaction history
        $transactions = WalletTransaction::where('user_id', $user->id)
                        ->latest()
                        ->paginate(10);

        return view('frontend.wallet.index', compact('userBalance', 'transactions'));
    }

    /**
     * Show top up form
     */
    public function topup()
    {
        $user = auth()->user();
        
        // Get or create user balance
        $userBalance = UserBalance::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        return view('frontend.wallet.topup', compact('userBalance'));
    }

    /**
     * Process top up request
     */
    public function processTopup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:10000000',
        ]);

        DB::beginTransaction();
        
        try {
            $user = auth()->user();
            
            // Get or create user balance
            $userBalance = UserBalance::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0]
            );

            $amount = $request->amount;
            $balanceBefore = $userBalance->balance;
            $balanceAfter = $balanceBefore + $amount;

            // Update balance
            $userBalance->balance = $balanceAfter;
            $userBalance->save();

            // Create transaction record
            WalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'topup',
                'amount' => $amount,
                'description' => 'Wallet Top Up',
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
            ]);

            DB::commit();

            return redirect()->route('wallet.index')->with('success', 'Top up successful! Your balance has been updated.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Top up failed. Please try again.');
        }
    }
}
