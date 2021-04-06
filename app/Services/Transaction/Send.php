<?php

declare(strict_types=1);

namespace App\Services\Transaction;

use App\Exceptions\TransactionException;
use App\Repositories\TransactionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\WalletRepositoryInterface;
use Exception;

/**
 * Class Send
 *
 * @package App\Services\Transaction
 */
class Send implements Transaction
{

    private $walletInterface;
    private $transactionRepository;
    private $userRepository;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        WalletRepositoryInterface $walletRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
        $this->walletInterface = $walletRepository;
    }

    /**
     * @param  array  $params
     * @return array
     * @throws Exception
     */
    public function handle(array $params): array
    {
        if ($params['payer_id'] === $params['payee_id']) {
            throw new TransactionException('Transaction cannot be sent to the same recipient', 409);
        }
        if ($this->walletInterface->getBalance($params['payer_id']) < 0) {
            throw new TransactionException('Amount is negative', 400);
        }
        $user = $this->userRepository->get($params['payer_id']);

        if ($user->type_person === 'J') {
            throw new TransactionException('This operation is not allowed', 401);
        }

        return ["message" => "transfer is success"];
    }
}