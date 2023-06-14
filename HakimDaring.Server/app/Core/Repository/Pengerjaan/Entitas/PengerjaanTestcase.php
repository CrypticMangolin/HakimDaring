<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

use App\Core\Repository\Testcase\Entitas\IDTestcase;

class PengerjaanTestcase {

    public function __construct(
        private IDPengerjaan $idPengerjaan,
        private IDTestcase $idTestcase,
        private ?HasilPengerjaanTestcase $hasil
    )
    {
        
    }

    public function ambilIDPengerjaan() : IDPengerjaan {
        return $this->idPengerjaan;
    }

    public function ambilIDTestcase() : IDTestcase {
        return $this->idTestcase;
    }

    public function ambilHasil() : HasilPengerjaanTestcase {
        return $this->hasil;
    }
}

?>