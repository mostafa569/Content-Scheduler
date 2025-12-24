<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'url|nullable',
            'scheduled_time' => 'date|after:now|nullable',
            'platforms' => 'required|array',
            'platforms.*' => 'exists:platforms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'content.required' => 'The content field is required.',
            'image_url.url' => 'The image URL must be a valid URL.',
            'scheduled_time.date' => 'The scheduled time must be a valid date.',
            'scheduled_time.after' => 'The scheduled time must be in the future.',
            'platforms.required' => 'At least one platform is required.',
            'platforms.array' => 'Platforms must be an array.',
            'platforms.*.exists' => 'One or more selected platforms are invalid.',
        ];
    }
}
