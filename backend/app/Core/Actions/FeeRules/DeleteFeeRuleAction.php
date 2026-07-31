<?php

declare(strict_types=1);

namespace App\Core\Actions\FeeRules;

use App\Core\Enums\AuditAction;
use App\Core\Enums\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Models\FeeRule;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class DeleteFeeRuleAction
{
    public function __construct(
        private AuditLogger $auditLogger,
    ) {
    }

    public function execute(
        FeeRule $feeRule,
        User $user,
    ): void {

        DB::transaction(function () use (
            $feeRule,
            $user,
        ): void {

            $this->auditLogger->log(
                user: $user,
                module: AuditModule::FEE_RULES->value,
                action: AuditAction::DELETED->value,
                description: 'Deleted fee rule.',
                metadata: [
                    'fee_rule_id' => $feeRule->id,
                ],
            );

            $feeRule->delete();
        });
    }
}