<?php

declare(strict_types=1);

namespace App\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
