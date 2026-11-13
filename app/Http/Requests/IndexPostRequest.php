<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexPostRequest extends FormRequest
{
    /**
     * The bulletin is public, so guests may search and filter it too.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Search and filter query-string values on /posts.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'tag' => ['nullable', 'string'],
        ];
    }
}
