<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

class IDPengerjaan {

    public function __construct(
        private int $idPengerjaan
    ) {}

    public function ambilID() : int {
        return $this->idPengerjaan;
    }
}

?>