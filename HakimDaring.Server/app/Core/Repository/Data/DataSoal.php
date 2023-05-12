<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

use InvalidArgumentException;

class DataSoal {

    private string $judul;
    private string $soal;

    private float $batasanWaktuPerTestcase;
    private float $batasanWaktuTotal;
    private int $batasanMemoriDalamKB;

    public function __construct(string $judul, string $soal, float $batasanWaktuPerTestcase, float $batasanWaktuTotal, int $batasanMemoriDalamKB)
    {
        if ($judul == null) {
            throw new InvalidArgumentException("judul bernilai null");
        }

        if ($soal == null) {
            throw new InvalidArgumentException("soal bernilai null");
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

        $this->judul = $judul;
        $this->soal = $soal;
        $this->batasanWaktuPerTestcase = $batasanWaktuPerTestcase;
        $this->batasanWaktuTotal = $batasanWaktuTotal;
        $this->batasanMemoriDalamKB = $batasanMemoriDalamKB;
    }

    public function ambilJudul() : string {
        return $this->judul;
    }

    public function ambilSoal() : string {
        return $this->soal;
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
}

?>