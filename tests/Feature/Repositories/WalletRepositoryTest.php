<?php

declare(strict_types=1);


namespace Tests\Feature\Repositories;


use Tests\TestCase;
use App\Models\User;
use App\Repositories\WalletRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class WalletRepositoryTest
 *
 * @package Tests\Feature\Repositories
 */
class WalletRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->walletRepository = $this->app->get(WalletRepositoryInterface::class);
    }

    public function testShouldBeInsertSuccess(): void
    {
        $user = User::factory()->create();
        $wallet = $this->walletRepository->insert($user->id, 20.0);
        self::assertEquals($user->id, $wallet['user_id']);
        $this->assertDatabaseHas(
            'wallets',
            [
                'user_id' => $user->id,
                'amount' => 20.0,
            ]
        );
    }

    public function testShouldBeGetBalanceWhenSuccess(): void
    {
        $user = User::factory()->create();
        $this->walletRepository->insert($user->id, 200000.0);
        $balance = $this->walletRepository->getBalance($user->id);
        self::assertEquals(200000.0, $balance);
    }
}