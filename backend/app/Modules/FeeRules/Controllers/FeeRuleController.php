<?php

declare(strict_types=1);

namespace App\Modules\FeeRules\Controllers;

use App\Models\FeeRule;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Core\Data\ValueObjects\FeeRuleFilters;

use App\Core\Services\FeeRules\FeeRuleQueryService;

use App\Core\Actions\FeeRules\CreateFeeRuleAction;
use App\Core\Actions\FeeRules\UpdateFeeRuleAction;
use App\Core\Actions\FeeRules\DeleteFeeRuleAction;

use App\Core\Data\ValueObjects\CreateFeeRuleData;
use App\Core\Data\ValueObjects\UpdateFeeRuleData;

use App\Modules\FeeRules\Requests\StoreFeeRuleRequest;
use App\Modules\FeeRules\Requests\UpdateFeeRuleRequest;

use App\Modules\FeeRules\Resources\FeeRuleCollection;
use App\Modules\FeeRules\Resources\FeeRuleResource;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class FeeRuleController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly CreateFeeRuleAction $createFeeRule,
        private readonly UpdateFeeRuleAction $updateFeeRule,
        private readonly DeleteFeeRuleAction $deleteFeeRule,
        private readonly FeeRuleQueryService $queryService,
    ) {
    }

    /**
     * Display a listing of fee rules.
     */
    public function index(
        Request $request,
    ): FeeRuleCollection {

        $this->authorize(
            'viewAny',
            FeeRule::class,
        );

        $filters = FeeRuleFilters::fromArray(
            $request->all(),
        );

        $feeRules = $this->queryService->paginate(
            $filters,
        );

        return new FeeRuleCollection(
            $feeRules,
        );
    }

    /**
     * Store a newly created fee rule.
     */
    public function store(
        StoreFeeRuleRequest $request,
    ): JsonResponse {

        $this->authorize(
            'create',
            FeeRule::class,
        );

        $user = User::firstOrFail();

        $feeRule = $this->createFeeRule->execute(
            CreateFeeRuleData::fromArray(
                $request->validatedData(),
            ),
            $user,
        );

        return (new FeeRuleResource(
            $feeRule,
        ))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified fee rule.
     */
    public function show(
        FeeRule $feeRule,
    ): FeeRuleResource {

        $this->authorize(
            'view',
            $feeRule,
        );

        return new FeeRuleResource(
            $feeRule->load('wallet'),
        );
    }

    /**
     * Update the specified fee rule.
     */
    public function update(
        UpdateFeeRuleRequest $request,
        FeeRule $feeRule,
    ): FeeRuleResource {

        $this->authorize(
            'update',
            $feeRule,
        );

        $user = User::firstOrFail();

        $feeRule = $this->updateFeeRule->execute(
            $feeRule,
            UpdateFeeRuleData::fromArray(
                $request->validatedData(),
            ),
            $user,
        );

        return new FeeRuleResource(
            $feeRule,
        );
    }

    /**
     * Remove the specified fee rule.
     */
    public function destroy(
        FeeRule $feeRule,
    ): Response {

        $this->authorize(
            'delete',
            $feeRule,
        );

        $user = User::firstOrFail();

        $this->deleteFeeRule->execute(
            $feeRule,
            $user,
        );

        return response()->noContent();
    }
}