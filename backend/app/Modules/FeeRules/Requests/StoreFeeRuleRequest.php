<?php

declare(strict_types=1);

namespace App\Modules\FeeRules\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreFeeRuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'wallet_id' => [
                'required',
                'integer',
                'exists:wallets,id',
            ],

            'minimum_amount' => [
                'required',
                'integer',
                'min:0',
            ],

            'maximum_amount' => [
                'required',
                'integer',
                'gte:minimum_amount',
            ],

            'fee' => [
                'required',
                'integer',
                'min:0',
            ],

            'priority' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],

            'effective_from' => [
                'nullable',
                'date',
            ],

            'effective_until' => [
                'nullable',
                'date',
                'after_or_equal:effective_from',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function validatedData(): array
    {
        return $this->validated();
    }
}