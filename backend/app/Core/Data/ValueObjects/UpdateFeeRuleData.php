<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

use Carbon\CarbonImmutable;

final readonly class UpdateFeeRuleData
{
    public function __construct(
        public int $walletId,
        public int $minimumAmount,
        public int $maximumAmount,
        public int $fee,
        public int $priority = 1,
        public bool $isActive = true,
        public ?CarbonImmutable $effectiveFrom = null,
        public ?CarbonImmutable $effectiveUntil = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            walletId: (int) $data['wallet_id'],

            minimumAmount: (int) $data['minimum_amount'],

            maximumAmount: (int) $data['maximum_amount'],

            fee: (int) $data['fee'],

            priority: isset($data['priority'])
                ? (int) $data['priority']
                : 1,

            isActive: isset($data['is_active'])
                ? (bool) $data['is_active']
                : true,

            effectiveFrom: isset($data['effective_from'])
                ? CarbonImmutable::parse($data['effective_from'])
                : null,

            effectiveUntil: isset($data['effective_until'])
                ? CarbonImmutable::parse($data['effective_until'])
                : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'wallet_id' => $this->walletId,
            'minimum_amount' => $this->minimumAmount,
            'maximum_amount' => $this->maximumAmount,
            'fee' => $this->fee,
            'priority' => $this->priority,
            'is_active' => $this->isActive,
            'effective_from' => $this->effectiveFrom,
            'effective_until' => $this->effectiveUntil,
        ];
    }
}