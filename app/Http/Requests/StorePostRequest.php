<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    /**
     * Only users with an author profile may post; residents get 403.
     */
    public function authorize(): bool
    {
        return $this->user()?->author !== null;
    }

    /**
     * An unchecked checkbox sends nothing, so turn its absence into false
     * before the rules run.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['is_published' => $this->boolean('is_published')]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'min:20'],
            'category' => ['required', Rule::in(Post::CATEGORIES)],
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['exists:tags,id'],
            'is_published' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tags.required' => 'Pick at least one tag.',
            'tags.min' => 'Pick at least one tag.',
            'tags.*.exists' => 'One of the selected tags does not exist.',
        ];
    }
}
