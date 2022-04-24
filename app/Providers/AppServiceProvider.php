<?php

namespace App\Providers;

use App\Repositories\Friend\FriendRepository;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\FriendRequest\FriendRequestInterface;
use App\Repositories\FriendRequest\FriendRequestRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            FriendRequestInterface::class,
            FriendRequestRepository::class
        );

        $this->app->singleton(
            FriendRepositoryInterface::class,
            FriendRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
