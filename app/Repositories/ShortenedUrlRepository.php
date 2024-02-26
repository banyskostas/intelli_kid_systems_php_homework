<?php

namespace App\Repositories;

use App\Interfaces\ShortenedUrlRepositoryInterface;
use App\Models\ShortenedUrl;
use \Illuminate\Database\Eloquent\Collection;

class ShortenedUrlRepository implements ShortenedUrlRepositoryInterface
{
    public function getAll(): Collection
    {
        return ShortenedUrl::all();
    }

    public function getById($id):? ShortenedUrl
    {
        return ShortenedUrl::findOrFail($id);
    }

    public function delete($id)
    {
        ShortenedUrl::destroy($id);
    }

    public function create(array $data): ShortenedUrl
    {
        return ShortenedUrl::create($data);
    }

    public function update($id, array $data): ShortenedUrl
    {
        return ShortenedUrl::whereId($id)->update($data);
    }

    public function getByPath(string $path):? ShortenedUrl
    {
        return ShortenedUrl::whereShortUrl($path)->first();
    }
}
