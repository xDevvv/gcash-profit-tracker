<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Controllers;

use App\Models\User;
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

use App\Core\Data\ValueObjects\TransactionFilters;
use App\Core\Services\Transactions\TransactionQueryService;
use Illuminate\Http\Request;

final class TransactionController extends Controller
{
    public function __construct(
        private readonly CreateTransactionAction $createTransaction,
        private readonly UpdateTransactionAction $updateTransaction,
        private readonly DeleteTransactionAction $deleteTransaction,
        private readonly TransactionQueryService $queryService,
    ) {
    }


    /**
     * Display a paginated list of transactions.
     */
    public function index(
        Request $request,
    ): TransactionCollection {

        // $this->authorize('viewAny', Transaction::class);

        $filters = TransactionFilters::fromArray(
            $request->all(),
        );

        $transactions = $this->queryService
            ->paginate($filters);

        return new TransactionCollection(
            $transactions,
        );
    }


    /**
     * Display the specified transaction.
     */
    public function show(
        Transaction $transaction,
    ): TransactionResource {

        // $this->authorize(
        //     'view',
        //     $transaction,
        // );

        $transaction->load([
            'user',
            'wallet',
        ]);

        return new TransactionResource($transaction);
    }

    public function store(
        StoreTransactionRequest $request,
    ): JsonResponse {

        // $this->authorize(
        //     'create',
        //     Transaction::class,
        // );

        $transaction = $this->createTransaction->execute(
            CreateTransactionData::fromArray(
                $request->validatedData()
            ),
            User::first(),
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

        // $this->authorize(
        //     'update',
        //     $transaction,
        // );

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

        // $this->authorize(
        //     'delete',
        //     $transaction,
        // );

        $this->deleteTransaction->execute($transaction);

        return response()->noContent();
    }


}
