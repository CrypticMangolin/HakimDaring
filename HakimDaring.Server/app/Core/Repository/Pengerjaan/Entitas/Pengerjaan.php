<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\DaftarSoal\Entitas\HasilPencarian;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use DateTime;

class Pengerjaan {

    public function __construct(
        private IDPengerjaan $idPengerjaan,
        private IDUser $IdPengerja,
        private IDSoal $idSoal,
        private VersiSoal $versiSoal,
        private SourceCodePengerjaan $sourceCode,
        private ?HasilPengerjaan $hasilPengerjaan,
        private DateTime $tanggalSubmit
    ) {

    }
    
    public function ambilIDPengerjaan() : IDPengerjaan {
        return $this->idPengerjaan;
    }
    
    public function ambilIDPengerja() : IDUser {
        return $this->IdPengerja;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    public function ambilVersiSoal() : VersiSoal {
        return $this->versiSoal;
    }

    public function ambilSourceCode() : SourceCodePengerjaan {
        return $this->sourceCode;
    }

    public function ambilHasil() : HasilPengerjaan {
        return $this->hasilPengerjaan;
    }

    public function ambilTanggalSubmit() : DateTime {
        return $this->tanggalSubmit;
    }
}

?>