<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Modules\Reports\Controllers\ReportController;

Route::prefix('reports')
    ->controller(ReportController::class)
    ->group(function (): void {

        Route::get(
            '/daily',
            'daily',
        );

        Route::get(
            '/weekly',
            'weekly',
        );

        Route::get(
            '/monthly',
            'monthly',
        );

        Route::get(
            '/custom',
            'custom',
        );

        Route::get(
            '/dashboard',
            'dashboardStatistics',
        );
    });