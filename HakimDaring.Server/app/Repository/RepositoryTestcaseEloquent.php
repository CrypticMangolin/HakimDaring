<?php 

declare(strict_types = 1);

namespace App\Repository;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\InterfaceRepositoryTestcase;
use ErrorException;

class RepositoryTestcaseEloquent implements InterfaceRepositoryTestcase {
    
    public function ambilKumpulanTestcaseDariSoal(IDSoal $idSoal) : array {
        throw new ErrorException();
    }

    /**
     * Untuk membuat testcase untuk soal tertentu.
     * 
     * @param IDSoal $idSoal id dari soal yang akan mendapatkan testcase
     * @param TestcaseData[] $kumpulanTestcase array berisi Testcase yang akan disimpan
     */
    public function setTestcaseUntukSoal(IDSoal $idSoal, array $kumpulanTestcase) : void {

    }

    /**
     * Untuk menghapus semua testcase soal tertentu.
     * 
     * @param IDSoal $idSoal id dari soal yang akan dihapus testcasenya
     */
    public function hapusSemuaTestcaseSoal(IDSoal $idSoal) : void {

    }
}

?>