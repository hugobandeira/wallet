<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;


use App\Models\User;
use App\Models\Wallet;
use App\Repositories\TransactionRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Class TransactionsControllerTest
 *
 * @package Tests\Feature\Http\Controllers
 */
class TransactionsControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     */
    public function testShouldBeTransactionErrorsValidation(): void
    {
        $response = $this->postJson('/api/transaction');
        $response->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => ['payer_id' => [], 'payee_id' => [], 'value' => []]
                ]
            );
    }

    public function testShouldBeTransactionBalanceIsInsufficient(): void
    {
        $users = User::factory()->count(2)->create();
        $response = $this->postJson(
            '/api/transaction',
            [
                "payer_id" => $users->first()->id,
                "payee_id" => $users->last()->id,
                "value" => 266.98
            ]
        );

        $this->assertDatabaseHas(
            'transactions',
            [
                'payer_id' => $users->first()->id,
                'payee_id' => $users->last()->id,
                'status' => 'ERROR',
                "value" => 266.98,
            ]
        );
        $response->assertStatus(400)->assertJson(['message' => 'Balance is insufficient']);
    }

    public function testShouldBeTransactionUserSame(): void
    {
        $users = User::factory()->count(1)->create();
        $response = $this->postJson(
            '/api/transaction',
            [
                "payer_id" => $users->first()->id,
                "payee_id" => $users->first()->id,
                "value" => 266.98
            ]
        );

        $this->assertDatabaseHas(
            'transactions',
            [
                'payer_id' => $users->first()->id,
                'payee_id' => $users->first()->id,
                'status' => 'ERROR',
            ]
        );
        $response->assertStatus(409)
            ->assertJson(['message' => 'Transaction cannot be sent to the same recipient']);
    }

    public function testShouldBeTransactionUserTypePersonNotAllowed(): void
    {
        $users = User::factory(2)
            ->has(
                Wallet::factory()
                    ->count(1)
                    ->state(
                        function ($attributes, User $user) {
                            return ['user_id' => $user->id, 'amount' => 20.0];
                        }
                    ),
                'wallet'
            )
            ->create(['type_person' => 'J']);

        $response = $this->postJson(
            '/api/transaction',
            [
                "payer_id" => $users->first()->id,
                "payee_id" => $users->last()->id,
                "value" => 2.98
            ]
        );

        $this->assertDatabaseHas(
            'transactions',
            [
                'payer_id' => $users->first()->id,
                'payee_id' => $users->last()->id,
                "value" => 2.98,
                'status' => 'ERROR',
            ]
        );
        $response->assertStatus(401)
            ->assertJson(['message' => 'Type of person not allowed']);
    }

    public function testShouldBeTransactionIsSuccess(): void
    {
        $users = User::factory(2)
            ->has(
                Wallet::factory()
                    ->count(1)
                    ->state(
                        function ($attributes, User $user) {
                            return ['user_id' => $user->id, 'amount' => 20.0];
                        }
                    ),
                'wallet'
            )
            ->create(['type_person' => 'F']);

        $response = $this->postJson(
            '/api/transaction',
            [
                "payer_id" => $users->first()->id,
                "payee_id" => $users->last()->id,
                "value" => 2.98
            ]
        );

        $this->assertDatabaseHas(
            'transactions',
            [
                'payer_id' => $users->first()->id,
                'payee_id' => $users->last()->id,
                "value" => 2.98,
                'status' => 'DONE',
            ]
        );

        $this->assertDatabaseHas(
            'wallets',
            [
                'user_id' => $users->first()->id,
                "amount" => -2.98,
            ]
        );


        $this->assertDatabaseHas(
            'wallets',
            [
                'user_id' => $users->last()->id,
                "amount" => 2.98,
            ]
        );

        $response->assertStatus(200)
            ->assertJson(['message' => 'transfer is success']);
    }

    public function testShouldBeTransactionIsException(): void
    {
        $transaction = $this->mock(TransactionRepositoryInterface::class);

        $transaction->shouldReceive('create')->with(1);
//        $transaction = $this->app->make(TransactionRepositoryInterface::class);

        $users = User::factory(2)
            ->has(
                Wallet::factory()
                    ->count(1)
                    ->state(
                        function ($attributes, User $user) {
                            return ['user_id' => $user->id, 'amount' => 20.0];
                        }
                    ),
                'wallet'
            )
            ->create(['type_person' => 'F']);

        $response = $this->postJson(
            '/api/transaction',
            [
                "payer_id" => $users->first()->id,
                "payee_id" => $users->last()->id,
                "value" => 2.98
            ]
        );

        $this->assertDatabaseMissing(
            'transactions',
            [
                'payer_id' => $users->first()->id,
                'payee_id' => $users->last()->id,
                "value" => 2.98,
                'status' => 'DONE',
            ]
        );

        $this->assertDatabaseMissing(
            'wallets',
            [
                'user_id' => $users->first()->id,
                "amount" => -2.98,
            ]
        );

        $this->assertDatabaseMissing(
            'wallets',
            [
                'user_id' => $users->last()->id,
                "amount" => 2.98,
            ]
        );

        $response->assertStatus(500)
            ->assertJson(['message' => 'transaction failed, try again']);
    }
}