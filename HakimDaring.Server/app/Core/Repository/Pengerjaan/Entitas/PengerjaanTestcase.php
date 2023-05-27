<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

use App\Core\Repository\Testcase\Entitas\IDTestcase;

class PengerjaanTestcase {

    public function __construct(
        private IDPengerjaan $idPengerjaan,
        private IDTestcase $idTestcase,
        private string $status,
        private float $waktu,
        private int $memori
    )
    {
        
    }

    public function ambilIDPengerjaan() : IDPengerjaan {
        return $this->idPengerjaan;
    }

    public function ambilIDTestcase() : IDTestcase {
        return $this->idTestcase;
    }

    public function ambilStatus() : string {
        return $this->status;
    }

    public function ambilWaktu() : float {
        return $this->waktu;
    }

    public function ambilMemori() : int {
        return $this->memori;
    }
}

?>