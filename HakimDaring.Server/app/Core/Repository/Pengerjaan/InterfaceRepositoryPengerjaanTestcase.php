<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan;

use App\Core\Repository\Pengerjaan\Entitas\IDPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\PengerjaanTestcase;

interface InterfaceRepositoryPengerjaanTestcase {

    public function save(PengerjaanTestcase $pengerjaan) : void;
}

?>