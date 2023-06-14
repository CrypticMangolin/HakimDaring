<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

class VersiSoal {

    public function __construct(
        private int $versi,
        private HasilSubmitSoal $hasilSubmitSoal
    )
    {
    }

    public function ambilVersi() : int {
        return $this->versi;
    }

    public function ambilHasilSubmitSoal() : HasilSubmitSoal {
        return $this->hasilSubmitSoal;
    }

    public function tambahVersiSoal() : void {
        $this->versi += 1;
        $this->hasilSubmitSoal->resetSubmit();
    }
}

?>