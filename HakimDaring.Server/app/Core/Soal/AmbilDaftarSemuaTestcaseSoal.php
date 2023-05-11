<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\InterfaceRepositorySoal;
use App\Core\Repository\InterfaceRepositoryTestcase;
use App\Core\Soal\Data\TidakMemilikiHakException;
use App\Core\Soal\Interface\InterfaceAmbilDaftarSemuaTestcaseSoal;
use InvalidArgumentException;

class AmbilDaftarSemuaTestcaseSoal implements InterfaceAmbilDaftarSemuaTestcaseSoal {

    private PengecekPembuatSoal $pengecekPembuatSoal;

    private InterfaceRepositoryTestcase $repositoryTestcase;

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(
        PengecekPembuatSoal $pengecekPembuatSoal,
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
        return $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($idSoal, $versiSoal);
    }
}

?>