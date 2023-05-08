<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\IDSoal;

interface InterfaceSetTestcaseSoal {

    /**
     * Untuk memberikan testcase pada sebuah soal
     * 
     * @param IDSoal $idSoal id dari soal yang akan mendapatkan testcasenya
     * @param array $testcaseBesertaJawaban
     * 
     * @return bool Bila terjadi perubahan testcase
     */
    public function setTestcase(IDSoal $idSoal, array $testcaseBesertaJawaban) : bool;
}

?>