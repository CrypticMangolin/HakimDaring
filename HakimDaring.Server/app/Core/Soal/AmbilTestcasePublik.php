<?php 

namespace App\Core\Soal;

use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\Entitas\TestcaseData;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use App\Core\Soal\Interface\InterfaceAmbilTestcasePublik;

class AmbilTestcasePublik implements InterfaceAmbilTestcasePublik {

    public function __construct(
        private InterfaceRepositorySoal $repositorySoal,
        private InterfaceRepositoryTestcase $repositoryTestcase
    )
    {
        
    }

    public function ambilDaftarTestcase(IDSoal $idSoal) : array {
        $versiSoal = $this->repositorySoal->ambilVersiSoal($idSoal);
        $daftarTestcase = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($idSoal, $versiSoal);

        $hasil = [];

        foreach($daftarTestcase as $testcase) {
            if ($testcase instanceof TestcaseData && $testcase->apakahSoalPublik()) {
                array_push($hasil, $testcase);
            }
        }

        return $hasil;
    }
}

?>