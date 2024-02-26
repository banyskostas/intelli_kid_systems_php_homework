<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrl\ShortUrlShowRequest;
use App\Http\Resources\ShortenedUrl\ShortenedUrlStoreResource;
use App\Models\ShortenedUrl;
use App\Services\ShortenedUrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ShortUrlController extends Controller
{
    private ShortenedUrlService $shortenedUrlService;

    public function __construct(
        ShortenedUrlService $shortenedUrlService,
    ) {
        $this->shortenedUrlService = $shortenedUrlService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function redirect(ShortUrlShowRequest $request)
    {
        $path = $request->validated('path');


        if (!$item = $this->shortenedUrlService->getByPath($path)) {
            abort(404, 'Short URL not found');
        }

        return response()->redirectTo($item->{ShortenedUrl::COL_URL}, Response::HTTP_MOVED_PERMANENTLY);
    }
}
