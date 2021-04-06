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
     * @return array
     */
    public function get(string $id): array
    {
        // TODO: Implement get() method.
        return [];
    }

    /**
     * @param  string  $id
     * @param  array  $params
     * @return bool
     */
    public function update(string $id, array $params): bool
    {
        $transaction = Transactions::find($id);
        return $transaction->update(
            [
                $params
            ]
        );
    }
}