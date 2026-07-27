<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Controllers;

use App\Core\Actions\Transactions\CreateTransactionAction;
use App\Core\Data\ValueObjects\CreateTransactionData;
use App\Modules\Transactions\Requests\StoreTransactionRequest;
use App\Modules\Transactions\Resources\TransactionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class TransactionController extends Controller
{
    public function __construct(
        private readonly CreateTransactionAction $createTransaction,
    ) {
    }

    public function store(
        StoreTransactionRequest $request,
    ): JsonResponse {

        $transaction = $this->createTransaction->execute(
            CreateTransactionData::fromArray(
                $request->validatedData()
            )
        );

        return (new TransactionResource($transaction))
            ->response()
            ->setStatusCode(201);
    }
}
