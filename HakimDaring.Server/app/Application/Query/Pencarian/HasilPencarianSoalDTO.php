<?php 

declare(strict_types = 1);

namespace App\Application\Query\Pencarian;

class HasilPencarianSoalDTO {

    public function __construct(
        public string $idSoal,
        public string $judul,
        public int $jumlahSubmit,
        public int $berhasilSubmit,
        public float $persentaseBerhasil
    )
    {

    }
}

?>

