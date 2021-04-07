<?php

declare(strict_types=1);

namespace App\Repositories;


use App\Models\Wallet;

/**
 * Class WalletRepository
 *
 * @package App\Repositories
 */
class WalletRepository implements WalletRepositoryInterface
{
    /**
     * @param  string  $userId
     * @return float
     */
    public function getBalance(string $userId): float
    {
        return Wallet::where('user_id', '=', $userId)->sum('amount');
    }

    /**
     * @param  string  $userId
     * @param  float  $amount
     * @return array
     */
    public function insert(string $userId, float $amount): array
    {
        return Wallet::create(
            [
                'amount' => $amount,
                'user_id' => $userId
            ]
        )->toArray();
    }
}