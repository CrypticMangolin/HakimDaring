<?php 

namespace App\Core\Soal\Interfaces;

use App\Core\Repository\Soal\Entitas\IDSoal;

interface InterfaceAmbilTestcasePublik {

    /**
     * Untuk mengambil testcase publik dari sebuah soal
     * 
     * @param IDSoal $idSoal id dari soal yang diambil testcasenya yang publik
     * 
     * @return TestcaseData[] daftar semua testcase soal
     */
    public function ambilDaftarTestcase(IDSoal $idSoal) : array;
}

?>