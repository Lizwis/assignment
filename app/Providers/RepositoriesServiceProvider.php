<?php

namespace App\Providers;

use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;

use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;


use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
