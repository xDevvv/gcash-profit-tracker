<?php

declare(strict_types=1);

use App\Modules\Transactions\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::apiResource(
    'transactions',
    TransactionController::class,
);
