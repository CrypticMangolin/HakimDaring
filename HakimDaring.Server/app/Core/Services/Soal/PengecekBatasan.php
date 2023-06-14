<?php 

declare(strict_types = 1);

namespace App\Core\Services\Soal;

use App\Core\Repository\Soal\Entitas\BatasanSoal;
use InvalidArgumentException;

class PengecekBatasan {

    public const WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON = 10.0;
    public const WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON = 20.0;
    public const MEMORI_MAKSIMAL_DALAM_KB = 128000;

    
    public function cekApakahBatasanMemenuhiSyarat(BatasanSoal $batasan) : void {
        
        if ($batasan->ambilBatasanWaktuPerTestcase() <= 0 || $batasan->ambilBatasanWaktuPerTestcase() > self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON) {
            throw new InvalidArgumentException("Batasan waktu per testcase harus lebih dari 0 sekon dan kurang dari ".self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON." sekon");
        }

        if ($batasan->ambilBatasanWaktuTotal() <= 0 || $batasan->ambilBatasanWaktuTotal() > self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON) {
            throw new InvalidArgumentException("Batasan waktu total testcase harus lebih dari 0 sekon dan kurang dari ".self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON." sekon");
        }
        
        if ($batasan->ambilBatasanMemoriDalamKB() <= 0 || $batasan->ambilBatasanMemoriDalamKB() > self::MEMORI_MAKSIMAL_DALAM_KB) {
            throw new InvalidArgumentException("Batasan waktu per testcase harus lebih dari 0 KB dan kurang dari ".self::MEMORI_MAKSIMAL_DALAM_KB." KB");
        }
    }
}

?>