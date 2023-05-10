<?php

namespace App\Providers;

use App\Core\Autentikasi\Login\Interface\InterfaceLogin;
use App\Core\Autentikasi\Login\Login;
use App\Core\Autentikasi\Logout\Interface\InterfaceLogout;
use App\Core\Autentikasi\Logout\Logout;
use App\Core\Autentikasi\Register\Interface\InterfaceRegister;
use App\Core\Autentikasi\Register\Register;
use App\Core\Soal\PengecekTestcaseDuplikat;
use App\Core\Soal\SetTestcaseSoal;
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
        $this->app->bind(InterfaceLogout::class, Logout::class);
        // $this->app->bind(InterfaceSetTestcaseSoal::class, function() {
        //     return new SetTestcaseSoal(new PengecekTestcaseDuplikat())
        // })
    }
}
