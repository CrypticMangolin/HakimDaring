<?php

namespace App\Providers;

use App\Core\Autentikasi\Login\Interface\InterfaceLogin;
use App\Core\Autentikasi\Login\Login;
use App\Core\Autentikasi\Logout\Interface\InterfaceLogout;
use App\Core\Autentikasi\Logout\Logout;
use App\Core\Autentikasi\Register\Interface\InterfaceRegister;
use App\Core\Autentikasi\Register\Register;
use App\Core\Soal\BuatSoal;
use App\Core\Soal\Interface\InterfaceBuatSoal;
use App\Core\Soal\Interface\InterfaceSetTestcaseSoal;
use App\Core\Soal\PengecekPembuatSoal;
use App\Core\Soal\PengecekTestcaseBaruBerbeda;
use App\Core\Soal\PengecekTestcaseDuplikat;
use App\Core\Soal\SetTestcaseSoal;
use App\Repository\RepositoryAutentikasiEloquent;
use App\Repository\RepositorySoalEloquent;
use App\Repository\RepositoryTestcaseEloquent;
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

        $this->app->bind(InterfaceBuatSoal::class, function() {
            return new BuatSoal(new RepositorySoalEloquent());
        });

        $this->app->bind(InterfaceSetTestcaseSoal::class, function() {
            $repositorySoal = new RepositorySoalEloquent();

            return new SetTestcaseSoal(
                new PengecekTestcaseDuplikat(),
                new RepositoryTestcaseEloquent(),
                new PengecekTestcaseBaruBerbeda(),
                new PengecekPembuatSoal($repositorySoal),
                $repositorySoal
            );
        });
    }
}
