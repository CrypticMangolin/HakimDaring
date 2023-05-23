<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use InvalidArgumentException;

class InformasiSoal {

    private Soal $soal;
    private float $batasanWaktuPerTestcase;
    private float $batasanWaktuTotal;
    private int $batasanMemoriDalamKB;
    private int $versi;
    private string $status;
    private int $totalSubmit;
    private int $totalBerhasil;
    private ?IDRuanganComment $idRuanganDiskusi;

    public function __construct(
        Soal $soal,
        int $versi,
        string $status,
        float $batasanWaktuPerTestcase, 
        float $batasanWaktuTotal, 
        int $batasanMemoriDalamKB,
        int $totalSubmit,
        int $totalBerhasil,
        ?IDRuanganComment $idRuanganDiskusi
    ) {

        if ($soal == null) {
            throw new InvalidArgumentException("soal bernilai null");
        }

        if ($status == null) {
            throw new InvalidArgumentException("status bernilai null");
        }

        if ($batasanWaktuPerTestcase == null) {
            throw new InvalidArgumentException("batasanWaktuPerTestcase bernilai null");
        }
        
        if ($batasanWaktuTotal == null) {
            throw new InvalidArgumentException("batasanWaktuTotal bernilai null");
        }
        
        if ($batasanMemoriDalamKB == null) {
            throw new InvalidArgumentException("batasanMemoriDalamKB bernilai null");
        }

        $this->soal = $soal;
        $this->versi = $versi;
        $this->status = $status;
        $this->batasanWaktuPerTestcase = $batasanWaktuPerTestcase;
        $this->batasanWaktuTotal = $batasanWaktuTotal;
        $this->batasanMemoriDalamKB = $batasanMemoriDalamKB;
        $this->totalSubmit = $totalSubmit;
        $this->totalBerhasil = $totalBerhasil;
        $this->idRuanganDiskusi = $idRuanganDiskusi;
    }

    public function ambilSoal() : Soal {
        return $this->soal;
    }

    public function ambilVersi() : int {
        return $this->versi;
    }

    public function ambilStatus() : string {
        return $this->status;
    }
    
    public function ambilBatasanWaktuPerTestcase() : float {
        return $this->batasanWaktuPerTestcase;
    }

    public function ambilBatasanWaktuTotal() : float {
        return $this->batasanWaktuTotal;
    }

    public function ambilBatasanMemoriDalamKB() : int {
        return $this->batasanMemoriDalamKB;
    }

    public function ambilTotalSubmit() : int {
        return $this->totalSubmit;
    }

    public function ambilTotalBerhasil() : int {
        return $this->totalBerhasil;
    }

    public function ambilIDRuanganDiskusi() : ?IDRuanganComment {
        return $this->idRuanganDiskusi;
    }
}

?>