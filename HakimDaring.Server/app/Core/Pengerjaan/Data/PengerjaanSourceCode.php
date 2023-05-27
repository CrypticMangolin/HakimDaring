<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Data;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;

class PengerjaanSourceCode {

    public function __construct(
        private IDUser $idUSer,
        private IDSoal $idSoal,
        private string $sourceCode,
        private int $bahasa
    ) {}

    public function ambilIDPembuat() : IDUser {
        return $this->idUSer;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    public function ambilSourceCode() : string {
        return $this->sourceCode;
    }

    public function ambilBahasa() : int {
        return $this->bahasa;
    }
}

?>