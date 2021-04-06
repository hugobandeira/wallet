<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Transaction;


use App\Services\Transaction\Send;
use App\Services\Transaction\TransactionFactory;
use Exception;
use Tests\TestCase;

/**
 * Class TransactionFactoryTest
 *
 * @package Tests\Unit\Services\Transaction
 */
class TransactionFactoryTest extends TestCase
{
    /**
     * @var TransactionFactory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = $this->app->get(TransactionFactory::class);
    }

    public function testInstance(): void
    {
        self::assertInstanceOf(Send::class, $this->factory->instance(Send::class));
    }

    public function testInstanceNotFound(): void
    {
        $this->expectException(Exception::class);
        $this->factory->instance('Class');
    }
}