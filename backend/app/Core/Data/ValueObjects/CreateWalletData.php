<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

final readonly class CreateWalletData
{
    public function __construct(
        public string $code,
        public string $displayName,
        public bool $isActive = true,
    ) {
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(
        array $data,
    ): self {

        return new self(
            code: strtoupper(
                trim($data['code'])
            ),

            displayName: trim(
                $data['display_name']
            ),

            isActive: $data['is_active'] ?? true,
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'display_name' => $this->displayName,
            'is_active' => $this->isActive,
        ];
    }
}
