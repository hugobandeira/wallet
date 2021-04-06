<?php

declare(strict_types=1);


namespace App\Repositories;


/**
 * Interface WallerRespositoryInterface
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
}