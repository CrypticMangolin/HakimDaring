<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Testcase\Entitas\TestcaseData;

interface InterfaceSetTestcaseSoal {

    /**
     * Untuk memberikan testcase pada sebuah soal
     * 
     * @param IDUser $idUser id dari user yang memberikan testcase
     * @param IDSoal $idSoal id dari soal yang akan mendapatkan testcasenya
     * @param BatasanSoal $batasanBaru batasan baru sumber daya untuk soal
     * @param TestcaseData[] $testcaseBesertaJawaban daftar testcase baru
     */
    public function setTestcase(IDUser $idUser, IDSoal $idSoal, BatasanSoal $batasanBaru, array $testcaseBesertaJawaban) : void;
}

?>