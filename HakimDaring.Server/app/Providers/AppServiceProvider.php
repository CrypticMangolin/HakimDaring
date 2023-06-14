<?php

namespace App\Providers;

use App\Application\Query\Pengerjaan\InterfaceQueryPengerjaan;
use App\Application\Query\Soal\InterfaceQuerySoal;
use App\Application\Query\Testcase\InterfaceQueryTestcase;
use App\Core\Services\Pengerjaan\InterfaceRequestServer;
use App\Infrastructure\Judge0\RequestServer;
use App\Infrastructure\Query\MySQL\QueryCommentMySQL;
use App\Infrastructure\Query\MySQL\QueryPengerjaanMySQL;
use App\Infrastructure\Query\MySQL\QuerySoalMySQL;
use App\Infrastructure\Query\MySQL\QueryTestcaseMySQL;
use App\Infrastructure\Repository\MySQL\RepositoryAutentikasiMySQL;
use App\Infrastructure\Repository\MySQL\RepositoryCommentMySQL;
use App\Infrastructure\Repository\MySQL\RepositoryDaftarSoalMySQL;
use App\Infrastructure\Repository\MySQL\RepositoryInformasiUserMySQL;
use App\Infrastructure\Repository\MySQL\RepositoryPengerjaanMySQL;
use App\Infrastructure\Repository\MySQL\RepositorySoalMySQL;
use App\Infrastructure\Repository\MySQL\RepositoryTestcaseMySQL;
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
        // REPOSITORY
        $this->app->bind(InterfaceRepositoryAutentikasi::class, RepositoryAutentikasiMySQL::class);
        $this->app->bind(InterfaceRepositoryComment::class, RepositoryCommentMySQL::class);
        $this->app->bind(InterfaceRepositoryDaftarSoal::class, RepositoryDaftarSoalMySQL::class);
        $this->app->bind(InterfaceRepositoryInformasiUser::class, RepositoryInformasiUserMySQL::class);
        $this->app->bind(InterfaceRepositoryPengerjaan::class, RepositoryPengerjaanMySQL::class);
        $this->app->bind(InterfaceRepositorySoal::class, RepositorySoalMySQL::class);
        $this->app->bind(InterfaceRepositoryTestcase::class, RepositoryTestcaseMySQL::class);

        // QUERY
        $this->app->bind(InterfaceQuerySoal::class, QueryCommentMySQL::class);
        $this->app->bind(InterfaceQueryPengerjaan::class, QueryPengerjaanMySQL::class);
        $this->app->bind(InterfaceQuerySoal::class, QuerySoalMySQL::class);
        $this->app->bind(InterfaceQueryTestcase::class, QueryTestcaseMySQL::class);

        // INFRASTRUCTURE
        $this->app->bind(InterfaceRequestServer::class, RequestServer::class);
    }
}
