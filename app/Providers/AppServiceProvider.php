<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ThreadTrending', function () {
            return new \App\Repository\TrendingRepository(new \App\Models\Thread);
        });
        $this->app->bind('DemandTrending', function () {
            return new \App\Repository\TrendingRepository(new \App\Models\Demand);
        });
        $this->app->bind('BookTrending', function () {
            return new \App\Repository\TrendingRepository(new \App\Models\Book);
        });
    }
}
