<?php 

namespace App\Core\Soal\Interface;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;

interface InterfaceAmbilDaftarSemuaTestcaseSoal {

    /**
     * Untuk mengambil semua testcase dari sebuah soal 
     * 
     * @param IDUser $idUser id [pengguna yang meminta request mengambil daftar testcase
     * @param IDSoal $idSoal id dari soal yang diambil datanya
     * 
     * @return TestcaseData[] daftar semua testcase soal
     */
    public function ambilDaftarTestcase(IDUser $idUser, IDSoal $idSoal) : array;
}

?>