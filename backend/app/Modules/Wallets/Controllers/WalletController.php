<?php

declare(strict_types=1);

namespace App\Modules\Wallets\Controllers;

use App\Models\User;
use App\Models\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Core\Data\ValueObjects\WalletFilters;

use App\Core\Services\Wallets\WalletQueryService;

use App\Core\Actions\Wallets\CreateWalletAction;
use App\Core\Actions\Wallets\UpdateWalletAction;
use App\Core\Actions\Wallets\DeleteWalletAction;

use App\Core\Data\ValueObjects\CreateWalletData;
use App\Core\Data\ValueObjects\UpdateWalletData;

use App\Modules\Wallets\Requests\StoreWalletRequest;
use App\Modules\Wallets\Requests\UpdateWalletRequest;

use App\Modules\Wallets\Resources\WalletResource;
use App\Modules\Wallets\Resources\WalletCollection;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class WalletController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private readonly CreateWalletAction $createWallet,
        private readonly UpdateWalletAction $updateWallet,
        private readonly DeleteWalletAction $deleteWallet,
        private readonly WalletQueryService $queryService,
    ) {
    }

    /**
     * Display a paginated list of wallets.
     */
    public function index(
        Request $request,
    ): WalletCollection {

        $this->authorize('viewAny', Wallet::class);

        $filters = WalletFilters::fromArray(
            $request->all(),
        );

        $wallets = $this->queryService
            ->paginate($filters);

        return new WalletCollection(
            $wallets,
        );
    }

    /**
     * Store a newly created wallet.
     */
    public function store(
        StoreWalletRequest $request,
    ): JsonResponse {

        $user = User::factory()->create();

        $wallet = $this->createWallet->execute(
            CreateWalletData::fromArray(
                $request->validatedData(),
            ),

            User::first() // TODO (Phase 7): Replace with $request->user() after implementing authentication.
            
        );

        return (new WalletResource($wallet))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified wallet.
     */
    public function show(
        Wallet $wallet,
    ): WalletResource {

        return new WalletResource(
            $wallet,
        );
    }

    /**
     * Update the specified wallet.
     */
    public function update(
        UpdateWalletRequest $request,
        Wallet $wallet,
    ): WalletResource {

        $wallet = $this->updateWallet->execute(
            $wallet,
            UpdateWalletData::fromArray(
                $request->validatedData(),
            ),
            User::first(), // TODO (Phase 7): Replace with $request->user() after implementing authentication.
        );

        return new WalletResource(
            $wallet,
        );
    }

    /**
     * Remove the specified wallet.
     */
    public function destroy(
        Wallet $wallet,
    ): Response {

        $this->deleteWallet->execute(
            $wallet,
            User::first() // TODO (Phase 7): Replace with $request->user() after implementing authentication.
        );

        return response()->noContent();
    }
}
