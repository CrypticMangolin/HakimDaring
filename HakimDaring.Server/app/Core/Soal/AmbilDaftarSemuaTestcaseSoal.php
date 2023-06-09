<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use App\Core\Soal\Exception\TidakMemilikiHakException;
use App\Core\Soal\Interfaces\InterfaceAmbilDaftarSemuaTestcaseSoal;
use App\Core\Soal\Interfaces\InterfacePengecekPembuatSoal;
use InvalidArgumentException;

class AmbilDaftarSemuaTestcaseSoal implements InterfaceAmbilDaftarSemuaTestcaseSoal {

    private InterfacePengecekPembuatSoal $pengecekPembuatSoal;

    private InterfaceRepositoryTestcase $repositoryTestcase;

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(
        InterfacePengecekPembuatSoal $pengecekPembuatSoal,
        InterfaceRepositoryTestcase $repositoryTestcase,
        InterfaceRepositorySoal $repositorySoal
    ) {
        
        if ($pengecekPembuatSoal == null) {
            throw new InvalidArgumentException("pengecekPembuatSoal bernilai null");
        }

        if ($repositoryTestcase == null) {
            throw new InvalidArgumentException("repositoryTestcase bernilai null");
        }

        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal bernilai null");
        }

        $this->pengecekPembuatSoal = $pengecekPembuatSoal;
        $this->repositoryTestcase = $repositoryTestcase;
        $this->repositorySoal = $repositorySoal;
    }

    public function ambilDaftarTestcase(IDUser $idUser, IDSoal $idSoal): array
    {
        if (!$this->pengecekPembuatSoal->cekApakahUserYangMembuatSoal($idUser, $idSoal)) {
            throw new TidakMemilikiHakException();
        }

        $versiSoal = $this->repositorySoal->ambilVersiSoal($idSoal);
        $daftarTestcaseDataSubmit = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($idSoal, $versiSoal);
        $daftarTestcaseData = [];
        foreach ($daftarTestcaseDataSubmit as $data) {
            array_push($daftarTestcaseData, $data->ambilDataTestcase());
        }

        return $daftarTestcaseData;
    }
}

?>