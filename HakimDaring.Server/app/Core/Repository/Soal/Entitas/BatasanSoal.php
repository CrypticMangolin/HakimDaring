<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

use InvalidArgumentException;

class BatasanSoal {

    public const WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON = 10.0;
    public const WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON = 20.0;
    public const MEMORI_MAKSIMAL_DALAM_KB = 128000;
    
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

    public static function buatBatasanSoal(float $batasanWaktuPerTestcase, float $batasanWaktuTotal, int $batasanMemoriDalamKB) : BatasanSoal {
        
        if ($batasanWaktuPerTestcase <= 0 || $batasanWaktuPerTestcase > self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON) {
            throw new InvalidArgumentException("Batasan waktu per testcase harus lebih dari 0 sekon dan kurang dari ".self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON." sekon");
        }

        if ($batasanWaktuTotal <= 0 || $batasanWaktuTotal > self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON) {
            throw new InvalidArgumentException("Batasan waktu total testcase harus lebih dari 0 sekon dan kurang dari ".self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON." sekon");
        }
        
        if ($batasanMemoriDalamKB <= 0 || $batasanMemoriDalamKB > self::MEMORI_MAKSIMAL_DALAM_KB) {
            throw new InvalidArgumentException("Batasan waktu per testcase harus lebih dari 0 KB dan kurang dari ".self::MEMORI_MAKSIMAL_DALAM_KB." KB");
        }

        return new BatasanSoal($batasanWaktuPerTestcase, $batasanWaktuTotal, $batasanMemoriDalamKB);
    }
}

?>