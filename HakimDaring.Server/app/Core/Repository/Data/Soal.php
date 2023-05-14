<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

use InvalidArgumentException;

class Soal extends DataSoal {

    private IDSoal $idSoal;

    public function __construct(?IDSoal $idSoal, string $judul, string $soal)
    {
        parent::__construct($judul, $soal);
        $this->idSoal = $idSoal;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

}

?>