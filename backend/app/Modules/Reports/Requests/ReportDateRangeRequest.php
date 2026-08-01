<?php

declare(strict_types=1);

namespace App\Modules\Reports\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ReportDateRangeRequest extends FormRequest
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
            'start' => [
                'required',
                'date',
            ],

            'end' => [
                'required',
                'date',
                'after_or_equal:start',
            ],
        ];
    }
}