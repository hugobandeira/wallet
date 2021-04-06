<?php

declare(strict_types=1);

namespace App\Services\Notification;

use Exception;
use Illuminate\Support\Facades\Http;

/**
 * Class AuthorizationService
 *
 * @package App\Services\Authorization
 */
class NotificationService implements NotificationServiceInterface
{
    /**
     * @var string
     */
    private $baseUri;

    /**
     * AuthorizationService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('notification.base_uri');
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isNotified(): bool
    {
        $response = Http::post($this->baseUri);
        if ($response->status() !== 200) {
            throw new Exception("Retry notification");
        }

        if ($response->json()['message'] !== 'Enviado') {
            throw new Exception("Retry notification");
        }

        return true;
    }
}