<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Traits\Uuid;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

/**
 * Class TransactionTest
 *
 * @package Tests\Unit\Models
 */
class TransactionTest extends TestCase
{
    /**
     * @var Transactions
     */
    private $transactionModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionModel = new Transactions();
    }

    public function testFillable(): void
    {
        $fillable = [
            'payer_id',
            'payee_id',
            'status',
            'value',
        ];

        self::assertEquals($fillable, $this->transactionModel->getFillable());
    }

    public function testIncrementing(): void
    {
        self::assertFalse($this->transactionModel->getIncrementing());
    }

    public function testCats(): void
    {
        $cats = [
            'id' => 'string'
        ];

        self::assertEquals($cats, $this->transactionModel->getCasts());
    }

    public function testShouldBeReceiveTraits(): void
    {
        $traits = [
            HasFactory::class,
            Uuid::class,
        ];

        self::assertEquals($traits, array_keys(class_uses($this->transactionModel)));
    }
}
