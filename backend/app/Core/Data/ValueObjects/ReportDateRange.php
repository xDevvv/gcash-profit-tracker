<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

use Carbon\CarbonImmutable;

final readonly class ReportDateRange
{
    public function __construct(
        public CarbonImmutable $start,
        public CarbonImmutable $end,
    ) {
    }

    /**
     * Create a ReportDateRange from an array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            start: CarbonImmutable::parse($data['start']),
            end: CarbonImmutable::parse($data['end']),
        );
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}