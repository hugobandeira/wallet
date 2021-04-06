<?php

declare(strict_types=1);

namespace App\Services\Transaction;

/**
 * Interface Transaction
 *
 * @package App\Services\Transaction
 */
interface Transaction
{
    /**
     * @param  array  $params
     * @return array
     */
    public function handle(array $params): array;
}