<?php

declare(strict_types=1);

namespace App\Services\Notification;

/**
 * Interface AuthorizationServiceInterface
 *
 * @package App\Services\Authorization
 */
interface NotificationServiceInterface
{
    /**
     * @return bool
     */
    public function isNotified(): bool;
}