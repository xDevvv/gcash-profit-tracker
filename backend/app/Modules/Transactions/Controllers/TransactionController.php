<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Controllers;

use App\Models\Transaction;
use App\Modules\Transactions\Resources\TransactionCollection;

use App\Core\Actions\Transactions\CreateTransactionAction;
use App\Core\Data\ValueObjects\CreateTransactionData;
use App\Core\Data\ValueObjects\UpdateTransactionData;
use App\Modules\Transactions\Requests\StoreTransactionRequest;
use App\Modules\Transactions\Resources\TransactionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Core\Actions\Transactions\DeleteTransactionAction;
use Symfony\Component\HttpFoundation\Response;

use App\Core\Actions\Transactions\UpdateTransactionAction;
use App\Modules\Transactions\Requests\UpdateTransactionRequest;

final class TransactionController extends Controller
{
    public function __construct(
        private readonly CreateTransactionAction $createTransaction,
        private readonly UpdateTransactionAction $updateTransaction,
        private readonly DeleteTransactionAction $deleteTransaction,
    ) {
    }


    /**
     * Display a paginated list of transactions.
     */
    public function index(): TransactionCollection
    {
        $transactions = Transaction::query()
            ->latest()
            ->paginate(15);

        return new TransactionCollection($transactions);
    }

    /**
     * Display the specified transaction.
     */
    public function show(
        Transaction $transaction,
    ): TransactionResource {
        $transaction->load([
            'user',
            'wallet',
        ]);

        return new TransactionResource($transaction);
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

    /**
     * Update the specified transaction.
     */
    public function update(
        UpdateTransactionRequest $request,
        Transaction $transaction,
    ): TransactionResource {

        $transaction = $this->updateTransaction->execute(
            $transaction,
            UpdateTransactionData::fromArray(
                $request->validatedData()
            )
        );

        return new TransactionResource($transaction);
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(
        Transaction $transaction,
    ): Response {

        $this->deleteTransaction->execute($transaction);

        return response()->noContent();
    }


}
