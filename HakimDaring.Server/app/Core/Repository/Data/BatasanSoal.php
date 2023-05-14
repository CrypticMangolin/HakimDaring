<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

use InvalidArgumentException;

class BatasanSoal {
    
    private float $batasanWaktuPerTestcase;
    private float $batasanWaktuTotal;
    private int $batasanMemoriDalamKB;

    public function __construct(float $batasanWaktuPerTestcase, float $batasanWaktuTotal, int $batasanMemoriDalamKB)
    {
        if ($batasanWaktuPerTestcase == null) {
            throw new InvalidArgumentException("batasanWaktuPerTestcase bernilai null");
        }
        
        if ($batasanWaktuTotal == null) {
            throw new InvalidArgumentException("batasanWaktuTotal bernilai null");
        }
        
        if ($batasanMemoriDalamKB == null) {
            throw new InvalidArgumentException("batasanMemoriDalamKB bernilai null");
        }

        $this->batasanWaktuPerTestcase = $batasanWaktuPerTestcase;
        $this->batasanWaktuTotal = $batasanWaktuTotal;
        $this->batasanMemoriDalamKB = $batasanMemoriDalamKB;
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