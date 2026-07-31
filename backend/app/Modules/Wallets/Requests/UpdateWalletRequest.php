<?php

declare(strict_types=1);

namespace App\Modules\Wallets\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateWalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        $wallet = $this->route('wallet');

        return [
            'code' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('wallets', 'code')
                    ->ignore($wallet),
            ],

            'display_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.unique' => 'Wallet code already exists.',

            'is_active.boolean' => 'Active flag must be true or false.',
        ];
    }

    /**
     * Return validated data.
     *
     * @return array<string, mixed>
     */
    public function validatedData(): array
    {
        return $this->validated();
    }
}
