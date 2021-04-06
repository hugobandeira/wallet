<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transactions;
use App\Repositories\TransactionRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class TransactionRepositoryTest
 *
 * @package Tests\Feature\Models
 */
class TransactionRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transactionRepository = $this->app->get(TransactionRepositoryInterface::class);
    }

    public function testShouldBeCreateTransactionSuccess(): void
    {
        $users = User::factory()->count(2)->create();
        $this->transactionRepository->create($users->first()->id, $users->last()->id, 20.0);

        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseHas(
            'transactions',
            [
                'payer_id' => $users->first()->id,
                'payee_id' => $users->last()->id,
                'value' => 20.0,
                'status' => 'PENDING',
            ]
        );
        $this->assertDatabaseMissing(
            'transactions',
            [
                'payee_id' => $users->first()->id,
                'payer_id' => $users->last()->id,
                'value' => 20.0,
                'status' => 'PENDING',
            ]
        );
    }

    public function testShouldBeUpdateTransactionSuccess(): void
    {
        $user = User::factory(1)
            ->has(
                Transactions::factory()
                    ->count(1)
                    ->state(
                        function ($attributes, User $user) {
                            return ['payer_id' => $user->id, 'payee_id' => $user->id];
                        }
                    ),
                'sendTransactions'
            )
            ->create();

        $this->transactionRepository->update(
            $user->first()->sendTransactions->first()->id,
            [
                'status' => 'DONE',
                'value' => 20.0,
            ]
        );

        $this->assertDatabaseCount('transactions', 1);

        $this->assertDatabaseHas(
            'transactions',
            [
                'payer_id' => $user->first()->id,
                'payee_id' => $user->first()->id,
                'status' => 'DONE',
                'value' => 20.0,
            ]
        );
    }
}