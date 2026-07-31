<?php

declare(strict_types=1);

namespace App\Core\Actions\FeeRules;

use App\Core\Data\ValueObjects\UpdateFeeRuleData;
use App\Core\Enums\AuditAction;
use App\Core\Enums\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Models\FeeRule;
use App\Models\User;

final readonly class UpdateFeeRuleAction
{
    public function __construct(
        private AuditLogger $auditLogger,
    ) {
    }

    public function execute(
        FeeRule $feeRule,
        UpdateFeeRuleData $data,
        User $user,
    ): FeeRule {

        $feeRule->update([
            'wallet_id' => $data->walletId,
            'minimum_amount' => $data->minimumAmount,
            'maximum_amount' => $data->maximumAmount,
            'fee' => $data->fee,
            'priority' => $data->priority,
            'is_active' => $data->isActive,
            'effective_from' => $data->effectiveFrom,
            'effective_until' => $data->effectiveUntil,
        ]);

        $this->auditLogger->log(
            user: $user,
            module: AuditModule::FEE_RULES->value,
            action: AuditAction::UPDATED->value,
            description: 'Updated fee rule.',
            metadata: [
                'fee_rule_id' => $feeRule->id,
            ],
        );

        return $feeRule->refresh();
    }
}