<?php

namespace App\Http\Requests\ShortUrl;

use App\Models\ShortenedUrl;
use Illuminate\Foundation\Http\FormRequest;

class ShortUrlShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'path' => 'required|string|regex:/^[a-z0-9-]+$/|size:' . ShortenedUrl::LENGTH_SHORT_URL,
        ];
    }

    public function validationData(): array
    {
        // Add the Route parameters to you data under validation
        return ['path' => $this->path()];
    }
}
