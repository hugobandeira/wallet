<?php

declare(strict_types=1);

namespace App\Services\Transaction;

use App\Exceptions\TransactionException;
use App\Jobs\ClientNotification;
use App\Repositories\TransactionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\WalletRepositoryInterface;
use App\Services\Authorization\AuthorizationServiceInterface;

/**
 * Class Send
 *
 * @package App\Services\Transaction
 */
class Send implements Transaction
{
    /**
     * @var WalletRepositoryInterface
     */
    private $walletInterface;
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;

    /**
     * Send constructor.
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
        $this->userRepository = $userRepository;
        $this->walletInterface = $walletRepository;
        $this->authorizationService = $authorizationService;
    }

    /**
     * @param  array  $params
     * @return string[]
     * @throws TransactionException
     */
    public function handle(array $params): array
    {
        $transaction = $this->transactionRepository->create($params['payer_id'], $params['payee_id'], $params['value']);
        try {
            $this->checkTransaction($params);
        } catch (TransactionException $exception) {
            $this->transactionRepository->update(
                $transaction['id'],
                [
                    'status' => 'ERROR'
                ]
            );
            throw $exception;
        }

        $this->walletInterface->insert($params['payer_id'], -$params['value']);
        $this->walletInterface->insert($params['payee_id'], $params['value']);

        $this->transactionRepository->update(
            $transaction['id'],
            [
                'status' => 'DONE',
            ]
        );

        dispatch(new ClientNotification($params));

        return ["message" => "transfer is success"];
    }

    /**
     * @param  array  $params
     * @return bool
     * @throws TransactionException
     */
    private function checkTransaction(array $params): bool
    {
        if ($params['payer_id'] === $params['payee_id']) {
            throw new TransactionException('Transaction cannot be sent to the same recipient', 409);
        }
        $balance = $this->walletInterface->getBalance($params['payer_id']);

        if ($balance < 0 || $params['value'] > $balance) {
            throw new TransactionException('Balance is insufficient', 400);
        }
        $user = $this->userRepository->get($params['payer_id']);

        if ($user['type_person'] === 'J') {
            throw new TransactionException('Type of person not allowed', 401);
        }

        if (!$this->authorizationService->isAuthorized()) {
            throw new TransactionException('This operation is not authorized', 401);
        }

        return true;
    }
}