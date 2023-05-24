<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

use App\Core\Repository\Soal\Entitas\IDSoal;

class PengerjaanSourceCode {

    public function __construct(
        private IDSoal $idSoal,
        private string $sourceCode
    ) {}

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    public function ambilSourceCode() : string {
        return $this->sourceCode;
    }
}

?>