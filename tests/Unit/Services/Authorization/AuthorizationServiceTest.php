<?php

declare(strict_types=1);


namespace Tests\Unit\Services\Authorization;


use App\Services\Authorization\AuthorizationServiceInterface;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Class AuthorizationServiceTest
 *
 * @package Tests\Unit\Services\Authorization
 */
class AuthorizationServiceTest extends TestCase
{

    /**
     * @var AuthorizationServiceInterface
     */
    private $authService;


    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = $this->app->make(AuthorizationServiceInterface::class);
    }

    /**
     * @dataProvider dataProviderAuth
     * @param $statusCode
     * @param $body
     * @param $expected
     */
    public function testResponseAuthorization($statusCode, $body, $expected)
    {
        Http::fake(
            [
                '*mocky.io/v3*' => Http::response(
                    $body,
                    $statusCode
                )
            ]
        );
        self::assertEquals($expected, $this->authService->isAuthorized());
    }

    /**
     * @return array[]
     */
    public function dataProviderAuth(): array
    {
        return [
            'Success' => [
                'statusCode' => 200,
                'body' => '{"message": "Autorizado"}',
                'expected' => true
            ],
            'Error Status code' => [
                'statusCode' => 500,
                'body' => '{"message": "Unauthorized"}',
                'expected' => false
            ],
            'Unauthorized' => [
                'statusCode' => 200,
                'body' => '{"message": "Unauthorized"}',
                'expected' => false
            ],
        ];
    }
}