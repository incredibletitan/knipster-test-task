<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend(
            'balanceMoreThanWithdrawAmount',
            'App\Validators\MoneyOperationValidator@balanceMoreThanWithdrawAmount'
        );

        Validator::extend(
            'dateStartLessOrEqualThanEnd',
            'App\Validators\MoneyOperationValidator@dateStartLessOrEqualThanEnd'
        );
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
