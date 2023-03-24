<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\StorageGatewayInterface;
use App\Services\ApiLogger;
use App\Services\Storage\DatabaseStorageGateway;
use App\Services\Storage\FileStorageGateway;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StorageGatewayInterface::class, function () {
            // Use database storage gateway
            // return new DatabaseStorageGateway();

            // Use file storage gateway
            return new DatabaseStorageGateway();
        });

        $this->app->singleton(ApiLogger::class, function () {
            return new ApiLogger(app(StorageGatewayInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
