<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Authorization\AuthorizationService;
use App\Services\Authorization\AuthorizationServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(AuthorizationServiceInterface::class, AuthorizationService::class);
    }
}
