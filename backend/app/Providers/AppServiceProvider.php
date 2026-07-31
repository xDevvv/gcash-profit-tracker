<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\FeeRule;

use App\Modules\Transactions\Policies\TransactionPolicy;
use App\Modules\Wallets\Policies\WalletPolicy;
use App\Modules\FeeRules\Policies\FeeRulePolicy;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(
            Transaction::class,
            TransactionPolicy::class,
        );

        Gate::policy(
            Wallet::class,
            WalletPolicy::class,
        );

        Gate::policy(
            FeeRule::class,
            FeeRulePolicy::class,
        );
    }
}