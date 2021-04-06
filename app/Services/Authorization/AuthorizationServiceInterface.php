<?php

declare(strict_types=1);

namespace App\Services\Authorization;

/**
 * Interface AuthorizationServiceInterface
 *
 * @package App\Services\Authorization
 */
interface AuthorizationServiceInterface
{
    /**
     * @return bool
     */
    public function isAuthorized(): bool;
}