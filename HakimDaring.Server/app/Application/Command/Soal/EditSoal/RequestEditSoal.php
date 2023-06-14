<?php 

declare(strict_types = 1);

namespace App\Application\Command\Soal\EditSoal;

class RequestEditSoal {

    public function __construct(
        public string $idSoal,
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