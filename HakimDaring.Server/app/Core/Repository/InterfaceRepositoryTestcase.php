<?php 

declare(strict_types = 1);

namespace App\Core\Repository;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\Testcase;
use App\Core\Repository\Data\TestcaseData;

interface InterfaceRepositoryTestcase {

    /**
     * Untuk mengambil kumpulan testcase dari sebuah soal
     * 
     * @param IDSoal $idSoal ID dari soal yang akan diambil testcasenya.
     * @return TestcaseData[] array kumpulan Testcase
     */
    public function ambilKumpulanTestcaseDariSoal(IDSoal $idSoal) : array;

    /**
     * Untuk membuat testcase untuk soal tertentu.
     * 
     * @param IDSoal $idSoal id dari soal yang akan mendapatkan testcase
     * @param TestcaseData[] $kumpulanTestcase array berisi Testcase yang akan disimpan
     */
    public function setTestcaseUntukSoal(IDSoal $idSoal, array $kumpulanTestcase) : void;

    /**
     * Untuk menghapus semua testcase soal tertentu.
     * 
     * @param IDSoal $idSoal id dari soal yang akan dihapus testcasenya
     */
    public function hapusSemuaTestcaseSoal(IDSoal $idSoal) : void;
}

?>