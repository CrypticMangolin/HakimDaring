<?php 

declare(strict_types = 1);

namespace App\Core\Services\Soal;

use App\Core\Repository\Testcase\Entitas\Testcase;
use App\Core\Soal\Interfaces\InterfacePengecekTestcaseDuplikat;
use InvalidArgumentException;

class PengecekTestcaseDuplikat {

    /**
     * @param Testcase[] $grupTestcase
     */
    public function cekApakahTestcaseDuplikat(array $grupTestcase) : bool {
        $bank = [];
        
        foreach($grupTestcase as $testcase) {
            $soal = $testcase->ambilSoalTestcase()->ambilSoal();
            if (array_key_exists($soal, $bank)) {
                return false;
            }
            else {
                $bank[$soal] = null;
            }
        }
        
        return true;
    }
}

?>