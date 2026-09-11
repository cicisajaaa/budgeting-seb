<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

use App\Models\PengajuanDana;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {

    }


    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

        Carbon::setLocale('id');


        View::composer(
            '*',
            function($view){

                $pendingApproval = PengajuanDana::where(
                    'status',
                    'pending'
                )->count();


                $view->with(
                    'pendingApproval',
                    $pendingApproval
                );

            }
        );

    }

}