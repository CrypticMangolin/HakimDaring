<?php 

declare(strict_types = 1);

namespace App\Application\Query\Pengerjaan;

class PengerjaanDTO {

    public function __construct(
        public string $idPengerjaan,
        public string $idPengsubmit,
        public string $namaPengsubmit,
        public string $idSoal,
        public string $namaSoal,
        public ?string $sourceCode,
        public string $bahasa,
        public string $hasil,
        public float $totalWaktu,
        public int $totalMemori,
        public string $tanggalSubmit,
        public bool $outdated,
    )
    {

    }
}

?>