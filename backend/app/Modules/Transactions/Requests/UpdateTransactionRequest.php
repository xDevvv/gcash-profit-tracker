<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Requests;

use App\Core\Enums\Transaction\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'wallet_id' => [
                'sometimes',
                'integer',
                'exists:wallets,id',
            ],

            'transaction_type' => [
                'sometimes',
                Rule::enum(TransactionType::class),
            ],

            'amount' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'wallet_id.exists' => 'The selected wallet does not exist.',

            'amount.integer' => 'Amount must be a whole number.',
            'amount.min' => 'Amount must be greater than zero.',

            'remarks.max' => 'Remarks may not exceed 255 characters.',
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
