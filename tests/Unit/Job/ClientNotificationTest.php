<?php

declare(strict_types=1);

namespace Tests\Unit\Job;


use App\Jobs\ClientNotification;
use App\Services\Notification\NotificationServiceInterface;
use Tests\TestCase;

/**
 * Class ClientNotificationTest
 *
 * @package Tests\Unit\Job
 */
class ClientNotificationTest extends TestCase
{
    private $notification;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notification = $this->mock(NotificationServiceInterface::class)
            ->shouldReceive('isNotified');
    }

    public function testShouldNotificationIsSuccess(): void
    {
        $this->notification->andReturnTrue()
            ->once();
        dispatch(new ClientNotification([]));
    }

    public function testShouldNotificationIsFalse(): void
    {
        $this->notification->andReturnFalse()
            ->once();
        dispatch(new ClientNotification([]));
    }


    public function testShouldException(): void
    {
        $this->notification->andReturnFalse()
            ->once()
            ->andReturn('123');
        dispatch(new ClientNotification([]));
    }
}