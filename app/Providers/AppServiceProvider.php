<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        //
        Schema::defaultStringLength(191);
        Validator::extend('late_dateearlier', function($attribute, $value, $parameters, $validator) {
            $date_compare = \Arr::get($validator->getData(), $parameters[0]);
            return Carbon::parse($date_compare) > Carbon::parse($value);
        });
        Validator::extend('leave_dateearlier', function($attribute, $value, $parameters, $validator) {
            $date_compare = \Arr::get($validator->getData(), $parameters[0]);
            return Carbon::parse($date_compare) >= Carbon::parse($value);
        });
    }
        
}
