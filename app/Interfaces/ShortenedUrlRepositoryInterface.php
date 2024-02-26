<?php

namespace App\Interfaces;

use App\Models\ShortenedUrl;
use Illuminate\Database\Eloquent\Collection;

interface ShortenedUrlRepositoryInterface
{
    public function getAll(): Collection;
    public function getById($id):? ShortenedUrl;
    public function delete($id);
    public function create(array $data): ShortenedUrl;
    public function update($id, array $data): ShortenedUrl;
    public function getByPath(string $path):? ShortenedUrl;
}
