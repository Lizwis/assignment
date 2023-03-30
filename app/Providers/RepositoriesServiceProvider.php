<?php

namespace App\Providers;

use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;

use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryInterface;

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
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }
}
