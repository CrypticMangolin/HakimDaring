<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Exception\TidakMemilikiHakException;
use App\Core\Repository\InformasiUser\Entitas\InformasiUser;
use App\Core\Repository\Testcase\Testcase;

class Soal {

    /**
     * @param Testcase[] $daftarTestcase
     */
    public function __construct(
        private IDSoal $idSoal,
        private IDUser $idPembuat,
        private PenjelasanSoal $penjelasanSoal,
        private BatasanSoal $batasanSoal,
        private VersiSoal $versiSoal,
        private StatusSoal $statusSoal,
        private ?IDRuanganComment $idRuanganComment
    )
    {

    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    public function ambilIDPembuat() : IDUser {
        return $this->idPembuat;
    }

    public function ambilPenjelasanSoal() : PenjelasanSoal {
        return $this->penjelasanSoal;
    }

    public function ambilBatasanSoal() : BatasanSoal {
        return $this->batasanSoal;
    }

    public function ambilVersiSoal() : VersiSoal {
        return $this->versiSoal;
    }

    public function ambilIDRuanganComment() : IDRuanganComment {
        return $this->idRuanganComment;
    }

    public function ambilStatusSoal() : StatusSoal {
        return $this->statusSoal;
    }

    public function gantiPenjelasanSoal(PenjelasanSoal $penjelasanSoal) : void {
        $this->penjelasanSoal = $penjelasanSoal;
    }

    public function gantiBatasanSoal(BatasanSoal $batasanSoal) : void {
        $this->batasanSoal = $batasanSoal;
    }
}

?>