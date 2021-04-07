<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array
     */
    public function allUsers(): array
    {
        return $this->userRepository->all();
    }
}
