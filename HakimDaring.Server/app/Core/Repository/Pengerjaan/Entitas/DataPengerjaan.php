<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use DateTime;

class DataPengerjaan {

    public function __construct(
        private IDUser $idUser,
        private IDSoal $idSoal,
        private VersiSoal $versiSoal,
        private string $sourceCode,
        private string $bahasa,
        private string $hasil,
        private float $totalWaktu,
        private int $totalMemori,
        private DateTime $tanggalSubmit
    ) {}
    
    public function ambilIDPembuat() : IDUser {
        return $this->idUser;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    public function ambilVersiSoal() : VersiSoal {
        return $this->versiSoal;
    }

    public function ambilBahasa() : string {
        return $this->bahasa;
    }

    public function ambilSourceCode() : string {
        return $this->sourceCode;
    }

    public function ambilHasil() : string {
        return $this->hasil;
    }

    public function ambilTotalWaktu() : float {
        return $this->totalWaktu;
    }

    public function ambilTotalMemori() : int {
        return $this->totalMemori;
    }

    public function ambilTanggalSubmit() : DateTime {
        return $this->tanggalSubmit;
    }
}

?>