<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AuthenticationRepositoryInterface;
use App\Repositories\AuthenticationRepository;
use App\Services\AuthenticationService;

use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Services\TaskService;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthenticationRepositoryInterface::class, AuthenticationRepository::class);
        $this->app->bind(AuthenticationService::class, function ($app) {
            return new AuthenticationService($app->make(AuthenticationRepositoryInterface::class));
        });

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });

        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TaskService::class, function ($app) {
            return new TaskService($app->make(TaskRepositoryInterface::class));
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
