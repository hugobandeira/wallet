<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

/**
 * Class WalletSeeder
 *
 * @package Database\Seeders
 */
class WalletSeeder extends Seeder
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
                Wallet::factory()
                    ->count(3)
                    ->state(
                        function ($attributes, User $user) {
                            return ['user_id' => $user->id];
                        }
                    ),
                'wallet'
            )
            ->create();
    }
}
