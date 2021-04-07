<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Notification;

use App\Services\Notification\NotificationService;
use Exception;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Class NotificationServiceTest
 *
 * @package Tests\Unit\Services\Notification
 */
class NotificationServiceTest extends TestCase
{
    /**
     * @var NotificationService
     */
    private $notificationService;


    protected function setUp(): void
    {
        parent::setUp();
        $this->notificationService = $this->app->make(NotificationService::class);
    }

    /**
     * @dataProvider dataProviderNotification
     * @param $statusCode
     * @param $body
     * @param $expected
     * @throws Exception
     */
    public function testNotificationService($statusCode, $body, $expected): void
    {
        Http::fake(
            [
                '*mocky.io/v3*' => Http::response(
                    $body,
                    $statusCode
                )
            ]
        );
        if ($statusCode !== 200) {
            $this->expectException($expected);
        }
        self::assertEquals($expected, $this->notificationService->isNotified());
    }

    /**
     * @return array[]
     */
    public function dataProviderNotification(): array
    {
        return [
            'Success' => [
                'statusCode' => 200,
                'body' => '{"message": "Enviado"}',
                'expected' => true,
            ],
            'Not notified success' => [
                'statusCode' => 200,
                'body' => '{"message": "Not notified"}',
                'expected' => false,
            ],
            'Not notified' => [
                'statusCode' => 400,
                'body' => '{"message": "Not notified"}',
                'expected' => Exception::class,
            ],
        ];
    }
}