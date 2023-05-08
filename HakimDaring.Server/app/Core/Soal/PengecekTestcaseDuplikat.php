<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Testcase;
use App\Core\Soal\PengecekTestcaseDuplikat as SoalPengecekTestcaseDuplikat;
use InvalidArgumentException;

class PengecekTestcaseDuplikat implements SoalPengecekTestcaseDuplikat {

    public function cekApakahTestcaseDuplikat(array $grupTestcase) : bool {
        $bank = [];
        
        foreach($grupTestcase as $testcase) {
            if ($testcase instanceof Testcase) {
                $soal = $testcase->ambilTestcase();
                if (array_key_exists($soal, $bank)) {
                    return false;
                }
                else {
                    $bank[$soal] = null;
                }
            }
            else {
                throw new InvalidArgumentException("Tipe data salah. Ekspektasi adalah object Testcase");
            }
        }
        
        return true;
    }
}

?>