<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

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