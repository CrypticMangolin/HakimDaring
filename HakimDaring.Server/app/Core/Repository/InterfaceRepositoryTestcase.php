<?php 

declare(strict_types = 1);

namespace App\Core\Repository;

interface InterfaceRepositoryTestcase {

    /**
     * Untuk mengambil kumpulan testcase dari sebuah soal
     * 
     * @param IDSoal $idSoal ID dari soal yang akan diambil testcasenya.
     * @return Testcase[] array kumpulan Testcase
     */
    public function ambilKumpulanTestcaseDariSoal(IDSoal $idSoal) : array;

    /**
     * Untuk membuat testcase untuk soal tertentu.
     * 
     * @param IDSoal $idSoal id dari soal yang akan mendapatkan testcase
     * @param Testcase[] $kumpulanTestcase array berisi Testcase yang akan disimpan
     */
    public function setTestcaseUntukSoal(IDSoal $idSoal, array $kumpulanTestcase) : void;
}

?>