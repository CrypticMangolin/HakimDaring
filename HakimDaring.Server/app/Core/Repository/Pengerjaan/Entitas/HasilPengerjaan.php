<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

class HasilPengerjaan {

    const ACCEPTED = "accepted";
    const ERROR = "error";

    public function __construct(
        private string $hasil,
        private float $totalWaktu,
        private int $totalMemori,
    ) {
        
    }

    public function ambilHasil() : string {
        return $this->hasil;
    }

    public function ambilTotalWaktu() : float {
        return $this->totalWaktu;
    }

    public function ambilTotalMemori() : int {
        return $this->totalMemori;
    }
}

?>