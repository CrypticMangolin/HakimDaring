<?php

namespace App\Providers;

use App\Core\Autentikasi\Login\InterfaceLogin;
use App\Core\Autentikasi\Login\Login;
use App\Core\Autentikasi\Register\InterfaceRegister;
use App\Core\Autentikasi\Register\Register;
use App\Repository\RepositoryAutentikasiEloquent;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(InterfaceLogin::class, Login::class);
        $this->app->bind(InterfaceRegister::class, function() {
            return new Register(new RepositoryAutentikasiEloquent());
        });
    }
}
