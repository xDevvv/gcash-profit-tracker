<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Modules\Wallets\Controllers\WalletController;

Route::prefix('wallets')
    ->controller(WalletController::class)
    ->group(function (): void {

        Route::get('/', 'index');
        Route::post('/', 'store');

        Route::get('{wallet}', 'show');
        Route::put('{wallet}', 'update');
        Route::delete('{wallet}', 'destroy');
    });
