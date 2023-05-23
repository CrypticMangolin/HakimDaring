<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

use InvalidArgumentException;

class Soal {

    private IDSoal $idSoal;
    private DataSoal $dataSoal;

    public function __construct(IDSoal $idSoal, DataSoal $dataSoal)
    {
        $this->idSoal = $idSoal;
        $this->dataSoal = $dataSoal;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    public function ambilDataSoal() : DataSoal {
        return $this->dataSoal;
    }
}

?>