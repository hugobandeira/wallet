<?php

declare(strict_types=1);


namespace App\Services\Transaction;


use App\Repositories\TransactionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\WalletRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Arr;

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
     * TransactionFactory constructor.
     *
     * @param  TransactionRepositoryInterface  $transactionRepository
     * @param  WalletRepositoryInterface  $walletRespository
     * @param  UserRepositoryInterface  $userRepository
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        WalletRepositoryInterface $walletRespository,
        UserRepositoryInterface $userRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRespository;
        $this->userRepository = $userRepository;
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
                return new Send($this->transactionRepository, $this->walletRepository, $this->userRepository);
                break;
            default:
                throw new Exception('Method not found');
        }
    }
}