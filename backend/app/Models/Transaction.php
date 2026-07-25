<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;

use App\Core\Enums\TransactionStatus;
use App\Core\Enums\TransactionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends BaseModel
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'wallet_id',
        'fee_rule_id',
        'reference_number',
        'transaction_type',
        'amount',
        'fee',
        'status',
        'remarks',
        'processed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'transaction_type' => TransactionType::class,
            'status'           => TransactionStatus::class,
            'amount'           => 'integer',
            'fee'              => 'integer',
            'processed_at'     => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function feeRule(): BelongsTo
    {
        return $this->belongsTo(FeeRule::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where(
            'status',
            TransactionStatus::COMPLETED
        );
    }

    public function scopeCashIn(Builder $query): Builder
    {
        return $query->where(
            'transaction_type',
            TransactionType::CASH_IN
        );
    }

    public function scopeCashOut(Builder $query): Builder
    {
        return $query->where(
            'transaction_type',
            TransactionType::CASH_OUT
        );
    }

    public function scopeForWallet(
        Builder $query,
        int $walletId
    ): Builder {
        return $query->where('wallet_id', $walletId);
    }

    public function scopeForUser(
        Builder $query,
        int $userId
    ): Builder {
        return $query->where('user_id', $userId);
    }

    public function scopeBetweenDates(
    Builder $query,
    CarbonInterface $start,
    CarbonInterface $end
    ): Builder {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeReference(
        Builder $query,
        string $reference
    ): Builder {
        return $query->where(
            'reference_number',
            $reference
        );
    }

    public function scopeAmountBetween(
        Builder $query,
        int $minimum,
        int $maximum
    ): Builder {
        return $query->whereBetween(
            'amount',
            [$minimum, $maximum]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isCashIn(): bool
    {
        return $this->transaction_type === TransactionType::CASH_IN;
    }

    public function isCashOut(): bool
    {
        return $this->transaction_type === TransactionType::CASH_OUT;
    }

    public function isCompleted(): bool
    {
        return $this->status === TransactionStatus::COMPLETED;
    }
}
