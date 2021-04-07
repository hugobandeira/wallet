<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Transactions;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class TransactionsSeeder
 *
 * @package Database\Seeders
 */
class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory(100)
            ->has(
                Transactions::factory()
                    ->count(3)
                    ->state(
                        function ($attributes, User $user) {
                            return ['payer_id' => $user->id, 'payee_id' => $user->id];
                        }
                    ),
                'sendTransactions'
            )
            ->create();
    }
}
