<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\TransactionException;
use App\Http\Requests\TransactionSendRequest;
use App\Services\Transaction\Send;
use App\Services\Transaction\TransactionFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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

    /**
     * TransactionsController constructor.
     *
     * @param  TransactionFactory  $transactionFactory
     */
    public function __construct(TransactionFactory $transactionFactory)
    {
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param  TransactionSendRequest  $request
     * @return JsonResponse|void
     */
    public function receiveTransaction(TransactionSendRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $sendService = $this->transactionFactory->instance(Send::class);
            $response = $sendService->handle($request->all());
            DB::commit();
            return response()->json($response);
        } catch (TransactionException $exception) {
            DB::commit();
            return response()
                ->json(
                    [
                        'message' => $exception->getMessage(),

                    ],
                    $exception->getCode()
                );
        } catch (Throwable $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'transaction failed, try again',
                ],
                500
            );
        }
    }
}
