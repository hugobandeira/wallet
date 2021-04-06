<?php

declare(strict_types=1);

namespace App\Repositories;

/**
 * Interface TransactionRepositoryInterface
 *
 * @package App\Repositories
 */
interface TransactionRepositoryInterface
{
    /**
     * @param  string  $id
     * @param  array  $params
     * @return bool
     */
    public function update(string $id, array $params): bool;

    /**
     * @param  string  $payer
     * @param  string  $payee
     * @param  float  $value
     * @return array
     */
    public function create(string $payer, string $payee, float $value): array;
}