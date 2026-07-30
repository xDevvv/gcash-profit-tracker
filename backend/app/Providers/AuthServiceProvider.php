<?php

declare(strict_types=1);

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Models\Transaction;
use App\Modules\Transactions\Policies\TransactionPolicy;


final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Transaction::class => TransactionPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}