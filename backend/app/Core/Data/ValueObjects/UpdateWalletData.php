<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

final readonly class UpdateWalletData
{
    public function __construct(
        public ?string $code = null,
        public ?string $displayName = null,
        public ?bool $isActive = null,
    ) {
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(
        array $data,
    ): self {

        return new self(
            code: isset($data['code'])
                ? strtoupper(trim($data['code']))
                : null,

            displayName: isset($data['display_name'])
                ? trim($data['display_name'])
                : null,

            isActive: $data['is_active'] ?? null,
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'code' => $this->code,
            'display_name' => $this->displayName,
            'is_active' => $this->isActive,
        ], static fn ($value) => $value !== null);
    }
}
