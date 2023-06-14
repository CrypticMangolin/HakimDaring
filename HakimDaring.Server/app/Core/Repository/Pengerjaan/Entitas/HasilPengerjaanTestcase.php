<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

class HasilPengerjaanTestcase {

    public function __construct(
        private string $hasil,
        private float $waktu,
        private int $memori,
    ) {
        
    }

    public function ambilHasil() : string {
        return $this->hasil;
    }

    public function ambilWaktu() : float {
        return $this->waktu;
    }

    public function ambilMemori() : int {
        return $this->memori;
    }
}

?>