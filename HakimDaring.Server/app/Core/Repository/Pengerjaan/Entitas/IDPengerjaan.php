<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

use Illuminate\Support\Str;

class IDPengerjaan {

    private string $idPengerjaan;

    public function __construct(?string $idPengerjaan) {
        $this->idPengerjaan = $idPengerjaan ? $idPengerjaan : Str::uuid()->toString();
    }

    public function ambilID() : string {
        return $this->idPengerjaan;
    }
}

?>