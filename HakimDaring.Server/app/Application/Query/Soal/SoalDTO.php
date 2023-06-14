<?php 

declare(strict_types = 1);

namespace App\Application\Query\Soal;

class SoalDTO {

    public function __construct(
        public string $idSoal,
        public string $judulSoal,
        public string $isiSoal,
        public float $batasanWaktuPerTestcase,
        public float $batasanWaktuTotal,
        public int $batasanMemori,
        public int $jumlahSubmit,
        public int $jumlahBerhasil,
        public string $status,
        public string $idRuanganDiskusi,
        public string $idPembuat,
        public string $namaPembuat,
    )
    {
    
    }
}

?>