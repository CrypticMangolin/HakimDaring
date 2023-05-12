<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

use InvalidArgumentException;

class Soal extends DataSoal {

    private IDSoal $idSoal;

    public function __construct(?IDSoal $idSoal, string $judul, string $soal, float $batasanWaktuPerTestcase, float $batasanWaktuTotal, int $batasanMemoriDalamKB)
    {
        parent::__construct($judul, $soal, $batasanWaktuPerTestcase, $batasanWaktuTotal, $batasanMemoriDalamKB);
        $this->idSoal = $idSoal;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

}

?>