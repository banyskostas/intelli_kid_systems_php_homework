<?php

namespace App\Http\Controllers;

use App\Exceptions\WrongPasscodeException;
use App\Http\Requests\ShortenedUrl\ShortenedUrlDestroyRequest;
use App\Http\Requests\ShortenedUrl\ShortenedUrlShowRequest;
use App\Http\Requests\ShortenedUrl\ShortenedUrlStoreRequest;
use App\Http\Resources\ShortenedUrl\ShortenedUrlShowResource;
use App\Http\Resources\ShortenedUrl\ShortenedUrlStoreResource;
use App\Interfaces\ShortenedUrlRepositoryInterface;
use App\Models\ShortenedUrl;
use App\Services\ShortenedUrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use LogicException;

class ShortenedUrlController extends Controller
{
    private ShortenedUrlRepositoryInterface $shortenedUrlRepository;
    private ShortenedUrlService $shortenedUrlService;

    public function __construct(
        ShortenedUrlRepositoryInterface $shortenedUrlRepository,
        ShortenedUrlService $shortenedUrlService,
    ) {
        $this->shortenedUrlRepository = $shortenedUrlRepository;
        $this->shortenedUrlService = $shortenedUrlService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShortenedUrlStoreRequest $request): JsonResponse
    {
        [$item, $passcode] = $this->shortenedUrlService->store($request->validated());

        // NOTE. This has to be the only place to reveal the passcode
        $item->{ShortenedUrl::COL_PASSCODE} = $passcode;

        return response()->json(new ShortenedUrlStoreResource($item), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortenedUrlShowRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return response()->json(
            new ShortenedUrlShowResource($this->shortenedUrlRepository->getById($validated['shortened_url']))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortenedUrlDestroyRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $this->shortenedUrlService->archive(
                $validated['shortened_url'],
                $validated[ShortenedUrl::COL_PASSCODE]
            );
        } catch (WrongPasscodeException $e) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
