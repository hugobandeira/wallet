<?php

declare(strict_types=1);


namespace App\Services\Transaction;


use App\Repositories\TransactionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\WalletRepositoryInterface;
use App\Services\Authorization\AuthorizationServiceInterface;
use Exception;

/**
 * Class TransactionFactory
 *
 * @package App\Services\Transaction
 */
class TransactionFactory
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;
    /**
     * @var WalletRepositoryInterface
     */
    private $walletRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;

    /**
     * TransactionFactory constructor.
     *
     * @param  TransactionRepositoryInterface  $transactionRepository
     * @param  WalletRepositoryInterface  $walletRepository
     * @param  UserRepositoryInterface  $userRepository
     * @param  AuthorizationServiceInterface  $authorizationService
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        WalletRepositoryInterface $walletRepository,
        UserRepositoryInterface $userRepository,
        AuthorizationServiceInterface $authorizationService
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
        $this->userRepository = $userRepository;
        $this->authorizationService = $authorizationService;
    }

    /**
     * @param  string  $class
     * @return Transaction
     * @throws Exception
     */
    public function instance(string $class): Transaction
    {
        switch ($class) {
            case Send::class:
                return new Send(
                    $this->transactionRepository,
                    $this->walletRepository,
                    $this->userRepository,
                    $this->authorizationService
                );
            default:
                throw new Exception('Method not found');
        }
    }
}