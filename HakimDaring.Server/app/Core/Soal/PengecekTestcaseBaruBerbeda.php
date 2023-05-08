<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Testcase;
use InvalidArgumentException;

class PengecekTestcaseBaruBerbeda implements InterfacePengecekTestcaseBaruBerbeda {

    public function cekApakahBerbeda(array $testcaseBaru, array $testcaseLama) : bool {
        if (count($testcaseBaru) != count($testcaseLama)) {
            return true;
        }

        $bank = [];

        foreach($testcaseBaru as $testcase) {
            if ($testcase instanceof Testcase) {
                $bank[$testcase->ambilTestcase()] = $testcase->ambilJawaban();
            }
            else {
                throw new InvalidArgumentException("Terdapat data testcase baru yang bukan Testcase");
            }
        }

        foreach($testcaseLama as $testcase) {
            if ($testcase instanceof Testcase) {
                if (array_key_exists($testcase->ambilTestcase(), $bank)) {
                    if ($bank[$testcase->ambilTestcase()] != $testcase->ambilJawaban()) {
                        return true;
                    }
                }
                else {
                    return true;
                }
            }
            else {
                throw new InvalidArgumentException("Terdapat data testcase lama yang bukan Testcase");
            }
        }

        return false;
    }
}

?>