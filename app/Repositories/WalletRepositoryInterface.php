<?php

declare(strict_types=1);


namespace App\Repositories;


/**
 * Interface WalletRepositoryInterface
 *
 * @package App\Repositories
 */
interface WalletRepositoryInterface
{
    /**
     * @param  string  $userId
     * @return float
     */
    public function getBalance(string $userId): float;

    /**
     * @param  string  $userId
     * @param  float  $amount
     * @return array
     */
    public function insert(string $userId, float $amount): array;
}