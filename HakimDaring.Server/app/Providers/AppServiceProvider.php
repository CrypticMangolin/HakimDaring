<?php

namespace App\Providers;

use App\Core\Autentikasi\Login\Interface\InterfaceLogin;
use App\Core\Autentikasi\Login\Login;
use App\Core\Autentikasi\Logout\Interface\InterfaceLogout;
use App\Core\Autentikasi\Logout\Logout;
use App\Core\Autentikasi\Register\Interface\InterfaceRegister;
use App\Core\Autentikasi\Register\Register;
use App\Core\Comment\Interface\InterfaceTambahComment;
use App\Core\Comment\TambahComment;
use App\Core\Pencarian\CariSoal;
use App\Core\Pencarian\Interface\InterfaceCariSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use App\Core\Soal\AmbilDaftarSemuaTestcaseSoal;
use App\Core\Soal\BuatSoal;
use App\Core\Soal\Interface\InterfaceAmbilDaftarSemuaTestcaseSoal;
use App\Core\Soal\Interface\InterfaceBuatSoal;
use App\Core\Soal\Interface\InterfaceSetTestcaseSoal;
use App\Core\Soal\Interface\InterfaceUbahSoal;
use App\Core\Soal\PengecekBatasanBerbeda;
use App\Core\Soal\PengecekPembuatSoal;
use App\Core\Soal\PengecekTestcaseBaruBerbeda;
use App\Core\Soal\PengecekTestcaseDuplikat;
use App\Core\Soal\SetTestcaseSoal;
use App\Core\Soal\UbahSoal;
use App\Infrastructure\MapperSortBy;
use App\Infrastructure\Repository\RepositoryAutentikasiEloquent;
use App\Infrastructure\Repository\RepositoryComment;
use App\Infrastructure\Repository\RepositoryDaftarSoalEloquent;
use App\Infrastructure\Repository\RepositorySoalEloquent;
use App\Infrastructure\Repository\RepositoryTestcaseEloquent;
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
            return new BuatSoal(new RepositorySoalEloquent(), new RepositoryComment());
        });

        $this->app->bind(InterfaceSetTestcaseSoal::class, function() {
            $repositorySoal = new RepositorySoalEloquent();

            return new SetTestcaseSoal(
                new PengecekTestcaseDuplikat(),
                new RepositoryTestcaseEloquent(),
                new PengecekTestcaseBaruBerbeda(),
                new PengecekBatasanBerbeda($repositorySoal),
                new PengecekPembuatSoal($repositorySoal),
                $repositorySoal
            );
        });

        $this->app->bind(InterfaceUbahSoal::class, function() {
            $repositorySoal = new RepositorySoalEloquent();
            return new UbahSoal(new PengecekPembuatSoal($repositorySoal), $repositorySoal);
        });

        $this->app->bind(InterfaceRepositorySoal::class, RepositorySoalEloquent::class);

        $this->app->bind(InterfaceAmbilDaftarSemuaTestcaseSoal::class, function() {
            $repositorySoal = new RepositorySoalEloquent();
            return new AmbilDaftarSemuaTestcaseSoal(
                new PengecekPembuatSoal($repositorySoal),
                new RepositoryTestcaseEloquent(),
                $repositorySoal
            );
        });

        $this->app->bind(InterfaceCariSoal::class, function() {
            return new CariSoal(new RepositoryDaftarSoalEloquent(new MapperSortBy()));
        });

        $this->app->bind(InterfaceTambahComment::class, TambahComment::class);
        $this->app->bind(InterfaceRepositoryComment::class, RepositoryComment::class);
    }
}
