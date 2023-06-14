<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Pengerjaan\Entitas\DataPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\IDPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\Pengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\PengerjaanTestcase;
use App\Core\Repository\Soal\Entitas\IDSoal;

interface InterfaceRepositoryPengerjaan {

    public function save(Pengerjaan $pengerjaan) : void;

    public function update(Pengerjaan $pengerjaan) : void;
}

?>