<?php

namespace App\Http\Resources\ShortenedUrl;

use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class ShortenedUrlStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return (new ShortenedUrlResource($this->resource))->toArray($request);
    }
}
