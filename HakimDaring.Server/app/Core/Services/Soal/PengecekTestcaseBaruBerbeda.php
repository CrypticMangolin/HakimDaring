<?php 

declare(strict_types = 1);

namespace App\Core\Services\Soal;

use App\Core\Repository\Testcase\Entitas\Testcase;
use App\Core\Soal\Interfaces\InterfacePengecekTestcaseBaruBerbeda;
use InvalidArgumentException;

class PengecekTestcaseBaruBerbeda {

    /**
     * @param Testcase[] $testcaseBaru
     * @param Testcase[] $testcaseLama
     */
    public function cekApakahBerbeda(array $testcaseBaru, array $testcaseLama) : bool {
        if (count($testcaseBaru) != count($testcaseLama)) {
            return true;
        }

        $bank = [];

        foreach($testcaseBaru as $testcase) {
            $bank[$testcase->ambilSoalTestcase()->ambilSoal()] = $testcase->ambilJawabanTestcase()->ambilJawaban();
        }

        foreach($testcaseLama as $testcase) {
            if (array_key_exists($testcase->ambilSoalTestcase()->ambilSoal(), $bank)) {
                if ($bank[$testcase->ambilSoalTestcase()->ambilSoal()] != $testcase->ambilJawabanTestcase()->ambilJawaban()) {
                    return true;
                }
            }
            else {
                return true;
            }
        }

        return false;
    }
}

?>