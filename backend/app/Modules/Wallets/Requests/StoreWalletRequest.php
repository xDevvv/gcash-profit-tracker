<?php

declare(strict_types=1);

namespace App\Modules\Wallets\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreWalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('wallets', 'code'),
            ],

            'display_name' => [
                'required',
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
            'code.required' => 'Wallet code is required.',
            'code.unique' => 'Wallet code already exists.',

            'display_name.required' => 'Display name is required.',

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
