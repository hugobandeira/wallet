<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Authorization\AuthorizationService;
use App\Services\Authorization\AuthorizationServiceInterface;
use App\Services\Notification\NotificationService;
use App\Services\Notification\NotificationServiceInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(AuthorizationServiceInterface::class, AuthorizationService::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
    }
}
