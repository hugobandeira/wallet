<?php

declare(strict_types=1);


namespace App\Services\Transaction;

/**
 * Interface TransactionFactoryInterface
 *
 * @package App\Services\Transaction
 */
interface TransactionFactoryInterface1
{
    /**
     * @param  string  $class
     * @return Transaction
     */
    public function instance(string $class): Transaction;
    //@todo rename for TransactionFactory
}