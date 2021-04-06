<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\TransactionSendRequest;
use Tests\TestCase;

/**
 * Class TransactionSendRequestTest
 *
 * @package Tests\Unit\app\Http\Requests
 */
class TransactionSendRequestTest extends TestCase
{
    /**
     * @var TransactionSendRequest
     */
    private $transactionRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transactionRequest = new TransactionSendRequest();
    }

    public function testAuthorize(): void
    {
        self::assertTrue($this->transactionRequest->authorize());
    }


    public function testRules(): void
    {
        $expected = [
            'payer_id' => 'required|exists:users,id',
            'payee_id' => 'required|exists:users,id',
            'value' => 'required|numeric|min:0.1',
        ];
        self::assertEquals($expected, $this->transactionRequest->rules());
    }

    public function testMessageRequired(): void
    {
        $expected = [
            'payer_id' => 'A payer is required',
            'payee_id' => 'A payee is required',
            'value' => 'A value is required',
        ];

        self::assertEquals($expected, $this->transactionRequest->messages());
    }
}