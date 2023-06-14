<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

class HasilSubmitSoal {

    public function __construct(
        private int $totalSubmit,
        private int $submitBerhasil
    )
    {
        
    }

    public function ambilTotalSubmit() : int {
        return $this->totalSubmit;
    }

    public function ambilSubmitBerhasil() : int {
        return $this->submitBerhasil;
    }

    public function ambilPersentaseBerhasil() : int {
        return $this->totalSubmit == 0 ? 0 : doubleval($this->submitBerhasil) / doubleval($this->totalSubmit);
    }

    public function resetSubmit() : void {
        $this->totalSubmit = 0;
        $this->submitBerhasil = 0;
    }

    public function tambahSubmit() : void {
        $this->totalSubmit += 1;
    }

    public function tambahSubmitBerhasil() : void {
        $this->tambahSubmit();
        $this->submitBerhasil += 1;
    }
}

?>