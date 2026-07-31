<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeRule extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'wallet_id',
        'minimum_amount',
        'maximum_amount',
        'fee',
        'priority',
        'is_active',
        'effective_from',
        'effective_until',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'minimum_amount' => 'integer',
            'maximum_amount' => 'integer',
            'fee'            => 'integer',
            'priority'       => 'integer',
            'is_active'      => 'boolean',
            'effective_from' => 'datetime',
            'effective_until'=> 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeForWallet(
        Builder $query,
        int $walletId
    ): Builder {
        return $query->where('wallet_id', $walletId);
    }

    public function scopeForAmount(
        Builder $query,
        int $amount
    ): Builder {
        return $query
            ->where('minimum_amount', '<=', $amount)
            ->where('maximum_amount', '>=', $amount);
    }

    public function scopeOrdered(
        Builder $query
    ): Builder {
        return $query
            ->orderBy('priority')
            ->orderBy('minimum_amount');
    }

    public function scopeEffectiveOn(
        Builder $query,
        \Carbon\CarbonInterface $date
    ): Builder {
        return $query
            ->where(function (Builder $query) use ($date) {
                $query->whereNull('effective_from')
                    ->orWhere('effective_from', '<=', $date);
            })
            ->where(function (Builder $query) use ($date) {
                $query->whereNull('effective_until')
                    ->orWhere('effective_until', '>=', $date);
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function matchesAmount(int $amount): bool
    {
        return $amount >= $this->minimum_amount
            && $amount <= $this->maximum_amount;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
