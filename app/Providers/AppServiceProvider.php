<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Channel;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        \View::composer('*', function($view){
            return $view->with('channels', Channel::all());
        });
        //\View::share('channels', Channel::all());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
       


    }
}
