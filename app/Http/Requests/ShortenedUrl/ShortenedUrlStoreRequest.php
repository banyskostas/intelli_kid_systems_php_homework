<?php

namespace App\Http\Requests\ShortenedUrl;

use App\Models\ShortenedUrl;
use Illuminate\Foundation\Http\FormRequest;

class ShortenedUrlStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO implement authorization in the near future and check permissions or access here
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
            ShortenedUrl::COL_URL => 'required|url',
            ShortenedUrl::COL_SHORT_URL => 'nullable|regex:/^[a-z0-9-]+$/|size:' . ShortenedUrl::LENGTH_SHORT_URL . '|unique:shortened_urls,short_url',
            ShortenedUrl::COL_VALID_UNTIL => 'nullable|date_format:Y-m-d H:i:s|after:now',
            ShortenedUrl::COL_PASSCODE => 'nullable|string|min:6|max:12',
        ];
    }
}
