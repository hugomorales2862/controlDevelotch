<?php

namespace App\Services;

use App\Models\PettyCash;
use Illuminate\Support\Facades\DB;
use Throwable;

class PettyCashService
{
    /**
     * @param array $data
     * @return PettyCash
     * @throws Throwable
     */
    public function recordTransaction(array $data): PettyCash
    {
        return DB::transaction(function () use ($data) {
            $lastTransaction = PettyCash::latest('id')->lockForUpdate()->first();
            $currentBalance = $lastTransaction ? (float) $lastTransaction->balance : 0.0;
            
            $amount = (float) $data['amount'];
            
            if ($data['type'] === 'income') {
                $newBalance = $currentBalance + $amount;
            } else {
                $newBalance = $currentBalance - $amount;
            }

            return PettyCash::create([
                ...$data,
                'balance' => $newBalance,
            ]);
        });
    }

    /**
     * Helper to retrieve current balance.
     */
    public function getCurrentBalance(): float
    {
        $lastTransaction = PettyCash::latest('id')->first();
        return $lastTransaction ? (float) $lastTransaction->balance : 0.0;
    }
}
