<?php

declare(strict_types=1);

use App\Core\Enums\TransactionStatus;
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
        Schema::create('transactions', function (Blueprint $table): void {

            $table->id();

            $table->string('reference_number', 30)
                ->unique();

            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('wallet_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('fee_rule_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('transaction_type');

            $table->string('status')
                ->default(TransactionStatus::COMPLETED->value);

            $table->unsignedBigInteger('amount');

            $table->unsignedBigInteger('fee');

            $table->text('remarks')
                ->nullable();

            $table->timestamp('transaction_at');

            $table->timestamps();

            $table->index('reference_number');

            $table->index('transaction_at');

            $table->index('transaction_type');

            $table->index('status');

            $table->index('user_id');

            $table->index('wallet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
