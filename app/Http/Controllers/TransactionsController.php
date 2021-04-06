<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\TransactionException;
use App\Http\Requests\TransactionSendRequest;
use App\Repositories\WalletRepositoryInterface;
use App\Services\Transaction\Send;
use App\Services\Transaction\TransactionFactory;
use App\Services\Transaction\TransactionFactoryInterface1;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class TransactionsController
 *
 * @package App\Http\Controllers
 */
class TransactionsController extends Controller
{
    /**
     * @var TransactionFactory
     */
    private $transactionFactory;

    public function __construct(TransactionFactory $transactionFactory)
    {
        $this->transactionFactory = $transactionFactory;
    }

    public function index()
    {
        return [
            'a' => 'a'
        ];
    }

    /**
     * @param  TransactionSendRequest  $request
     * @return JsonResponse|void
     */
    public function receiveTransaction(TransactionSendRequest $request): JsonResponse
    {
        try {
            $sendService = $this->transactionFactory->instance(Send::class);
            $response = $sendService->handle($request->all());
            return response()->json($response);
        } catch (TransactionException $exception) {
            return response()
                ->json(
                    [
                        'message' => $exception->getMessage(),

                    ],
                    $exception->getCode()
                );
        } catch (\Throwable $exception) {
            dd($exception->getMessage(), 'qui');
            return response()->json([]);
        }
    }
}
