<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Data\Testcase;
use App\Core\Soal\Interface\InterfacePengecekTestcaseDuplikat;
use InvalidArgumentException;

class PengecekTestcaseDuplikat implements InterfacePengecekTestcaseDuplikat {

    public function cekApakahTestcaseDuplikat(array $grupTestcase) : bool {
        $bank = [];
        
        foreach($grupTestcase as $testcase) {
            if (!($testcase instanceof Testcase)) {
                throw new InvalidArgumentException("Tipe data salah. Ekspektasi adalah object Testcase");
            }
            
            $soal = $testcase->ambilTestcase();
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