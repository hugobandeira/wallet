<?php

declare(strict_types=1);


namespace App\Repositories;

/**
 * Interface UserRepositoryInterface
 *
 * @package App\Repositories
 */
interface UserRepositoryInterface
{
    /**
     * @param  string  $userId
     * @return array
     */
    public function get(string $userId): array;
}