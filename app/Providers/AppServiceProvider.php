<?php

namespace App\Providers;

use Encore\Admin\Config\Config;
use Illuminate\Support\ServiceProvider;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Application $app)
    {
        \Carbon\Carbon::setLocale('zh');
        View::share('js', $app->js);
        if (! app()->environment('testing')) {
            Config::load();
        }
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
        if (config('app.debug')) {
            $this->app->register('VIACreative\SudoSu\ServiceProvider');
        }
    }
}
