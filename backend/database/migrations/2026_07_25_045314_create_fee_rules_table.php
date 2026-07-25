<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fee_rules', function (Blueprint $table): void {

            $table->id();

            $table->foreignId('wallet_id')
                ->constrained()
                ->restrictOnDelete();

            $table->unsignedBigInteger('minimum_amount');

            $table->unsignedBigInteger('maximum_amount');

            $table->unsignedBigInteger('fee');

            $table->unsignedInteger('priority')
                ->default(1);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamp('effective_from')
                ->nullable();

            $table->timestamp('effective_until')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index('wallet_id');

            $table->index('is_active');

            $table->index([
                'minimum_amount',
                'maximum_amount',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_rules');
    }
};
