<?php

namespace App\Http\Requests\ShortenedUrl;

use App\Models\ShortenedUrl;
use Illuminate\Foundation\Http\FormRequest;

class ShortenedUrlDestroyRequest extends FormRequest
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
            'shortened_url' => 'required|numeric|exists:shortened_urls,id',
            ShortenedUrl::COL_PASSCODE => 'required|string|min:6|max:12',
        ];
    }

    public function validationData(): array
    {
        // Add the Route parameters to you data under validation
        return array_merge($this->all(),$this->route()->parameters());
    }
}
