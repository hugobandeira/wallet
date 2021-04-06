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
    public function get(string $userId)
    {
        return User::find($userId);
    }
}