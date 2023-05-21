<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase;

use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;

interface InterfaceRepositoryTestcase {

    /**
     * Untuk mengambil kumpulan testcase dari sebuah soal
     * 
     * @param IDSoal $idSoal ID dari soal yang akan diambil testcasenya.
     * @param VersiSoal $versiSoal versi testcase yang berasal dari versi soal
     * 
     * @return TestcaseData[] array kumpulan Testcase
     */
    public function ambilKumpulanTestcaseDariSoal(IDSoal $idSoal, VersiSoal $versiSoal) : array;

    /**
     * Untuk membuat testcase untuk soal tertentu.
     * 
     * @param IDSoal $idSoal id dari soal yang akan mendapatkan testcase
     * @param VersiSoal $versiSoal versi untuk testcase berdasarkan versi soal
     * @param TestcaseData[] $kumpulanTestcase array berisi Testcase yang akan disimpan
     */
    public function setTestcaseUntukSoal(IDSoal $idSoal, VersiSoal $versiSoal, array $kumpulanTestcase) : void;
}

?>