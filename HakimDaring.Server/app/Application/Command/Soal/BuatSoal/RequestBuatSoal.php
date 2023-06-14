<?php 

declare(strict_types = 1);

namespace App\Application\Command\Soal\BuatSoal;

class RequestBuatSoal {

    public function __construct(
        public string $judulSoal,
        public string $soal,
        public float $batasanSoalWaktuPerTestcase,
        public float $batasanSoalTotalWaktu,
        public int $batasanSoalMemori,
        public array $daftarTestcase
    )
    {
        
    }
}

?>