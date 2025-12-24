<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string|max:255',
            'content' => 'string',
            'image_url' => 'url|nullable',
            'scheduled_time' => 'date|after:now|nullable',
            'platforms' => 'array',
            'platforms.*' => 'exists:platforms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'content.string' => 'The content must be a string.',
            'image_url.url' => 'The image URL must be a valid URL.',
            'scheduled_time.date' => 'The scheduled time must be a valid date.',
            'scheduled_time.after' => 'The scheduled time must be in the future.',
            'platforms.array' => 'Platforms must be an array.',
            'platforms.*.exists' => 'One or more selected platforms are invalid.',
        ];
    }
}
