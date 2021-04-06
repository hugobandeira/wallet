<?php

declare(strict_types=1);


namespace App\Repositories;

use App\Models\Transactions;

/**
 * Class TransactionRepository
 *
 * @package App\Repositories
 */
class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @param  string  $id
     * @param  array  $params
     * @return bool
     */
    public function update(string $id, array $params): bool
    {
        $transaction = Transactions::find($id);
        return $transaction->update($params);
    }

    /**
     * @param  string  $payer
     * @param  string  $payee
     * @param  float  $value
     * @return array
     */
    public function create(string $payer, string $payee, float $value): array
    {
        return Transactions::create(
            [
                'payer_id' => $payer,
                'payee_id' => $payee,
                'value' => $value
            ]
        )->toArray();
    }
}