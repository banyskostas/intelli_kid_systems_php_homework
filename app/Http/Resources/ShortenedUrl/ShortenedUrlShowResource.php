<?php

namespace App\Http\Resources\ShortenedUrl;

use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortenedUrlShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ShortenedUrl $item */
        $item = $this->resource;

        return $item->only([
            ShortenedUrl::COL_ID,
            ShortenedUrl::COL_URL,
            ShortenedUrl::COL_SHORT_URL,
            ShortenedUrl::COL_VALID_UNTIL,
            ShortenedUrl::COL_CREATED_AT,
        ]);
    }
}
