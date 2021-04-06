<?php

declare(strict_types=1);

namespace App\Repositories;


use App\Models\User;

/**
 * Class UserRepository
 *
 * @package App\Repositories
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @param  string  $userId
     * @return array
     */
    public function get(string $userId): array
    {
        return User::find($userId)->toArray();
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return User::all()->append('balance')->toArray();
    }
}