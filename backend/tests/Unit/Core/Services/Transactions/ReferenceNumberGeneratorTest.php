<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Services\Transactions;

use App\Core\Services\Transactions\ReferenceNumberGenerator;
use Tests\TestCase;

final class ReferenceNumberGeneratorTest extends TestCase
{
    private ReferenceNumberGenerator $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = app(ReferenceNumberGenerator::class);
    }

    public function test_it_generates_a_reference_number(): void
    {
        $reference = $this->generator->generate();

        $this->assertNotEmpty($reference);
        $this->assertIsString($reference);
    }

    public function test_generated_reference_number_matches_expected_format(): void
    {
        $reference = $this->generator->generate();

        // Update this regex to match your generator format.
        $this->assertMatchesRegularExpression(
            '/^TRX-\d{8}-\d{6}$/',
            $reference
        );
    }

    public function test_generated_reference_numbers_are_unique(): void
    {
        $first = $this->generator->generate();
        $second = $this->generator->generate();

        $this->assertNotEquals($first, $second);
    }
}
