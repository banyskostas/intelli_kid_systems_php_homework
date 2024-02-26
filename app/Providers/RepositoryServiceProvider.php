<?php

namespace App\Providers;

use App\Interfaces\ShortenedUrlRepositoryInterface;
use App\Repositories\ShortenedUrlRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ShortenedUrlRepositoryInterface::class, ShortenedUrlRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
