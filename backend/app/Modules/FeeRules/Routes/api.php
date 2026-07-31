<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Modules\FeeRules\Controllers\FeeRuleController;

Route::apiResource(
    'fee-rules',
    FeeRuleController::class,
);