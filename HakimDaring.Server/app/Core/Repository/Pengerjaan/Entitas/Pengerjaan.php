<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use DateTime;

class Pengerjaan {

    public function __construct(
        private IDPengerjaan $iDPengerjaan,
        private DataPengerjaan $dataPengerjaan
    ) {}
    
    public function ambilIDPengerjaan() : IDPengerjaan {
        return $this->iDPengerjaan;
    }

    public function ambilDataPengerjaan() : DataPengerjaan {
        return $this->dataPengerjaan;
    }
}

?>