<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Traits\Uuid;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

/**
 * Class WalletTest
 *
 * @package Tests\Unit\Models
 */
class WalletTest extends TestCase
{
    /**
     * @var Wallet
     */
    private $walletModel;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->walletModel = new Wallet();
    }

    /**
     *
     */
    public function testFillable(): void
    {
        $fillable = [
            'amount',
            'user_id',
        ];

        self::assertEquals($fillable, $this->walletModel->getFillable());
    }

    /**
     *
     */
    public function testIncrementing(): void
    {
        self::assertFalse($this->walletModel->getIncrementing());
    }

    public function testCats(): void
    {
        $cats = [
            'id' => 'string'
        ];

        self::assertEquals($cats, $this->walletModel->getCasts());
    }

    public function testShouldBeReceiveTraits(): void
    {
        $traits = [
            HasFactory::class,
            Uuid::class,
        ];

        self::assertEquals($traits, array_keys(class_uses($this->walletModel)));
    }
}
