<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

class VersiSoal {
    private int $versi;

    public function __construct(int $versi)
    {
        $this->versi = $versi;
    }

    public function ambilVersi() : int {
        return $this->versi;
    }
}

?>