<?php

namespace App\Providers;

use App\AppHelpers\Transformers\CityTransformer;
use App\AppHelpers\Transformers\NullTransformer;
use app\AppHelpers\Transformers\UserTransformer;
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->when('App\Http\Controllers\CityController')
            ->needs('App\AppHelpers\Transformers\CityTransformer')
            ->give(function () {
                return new CityTransformer();
            });

        $this->app->when('App\Http\Controllers\UsersController')
            ->needs('App\AppHelpers\Transformers\UserTransformer')
            ->give(function () {
                return new UserTransformer();
            });


        $this->app->bind('App\AppHelpers\Transformers\Transformer', function()
        {
            return new NullTransformer();
        });
    }
}
