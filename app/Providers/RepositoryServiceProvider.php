<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\DocumentRepositoryInterface;
use App\Repositories\DocumentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            DocumentRepositoryInterface::class,
            DocumentRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}