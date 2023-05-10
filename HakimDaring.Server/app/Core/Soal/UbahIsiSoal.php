<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\Soal;
use App\Core\Repository\InterfaceRepositorySoal;
use App\Core\Soal\Interface\InterfacePengecekPembuatSoal;
use App\Core\Soal\Interface\InterfaceUbahIsiSoal;
use InvalidArgumentException;

class UbahIsiSoal implements InterfaceUbahIsiSoal {
    
    private InterfacePengecekPembuatSoal $pengecekPembuatSoal;

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(
        InterfacePengecekPembuatSoal $pengecekPembuatSoal,
        InterfaceRepositorySoal $repositorySoal
    ) {
        if ($pengecekPembuatSoal == null) {
            throw new InvalidArgumentException("pengecekPembuatSoal bernilai null");
        }

        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal bernilai null");
        }

        $this->pengecekPembuatSoal = $pengecekPembuatSoal;
        $this->repositorySoal = $repositorySoal;
    }

    public function ubahIsiSoal(IDUser $idUser, Soal $soalBaru): void
    {
        if ($this->pengecekPembuatSoal->cekApakahUserYangMembuatSoal($idUser, $soalBaru->ambilIDSoal())) {
            $this->repositorySoal->ubahSoal($soalBaru);
        }
    }
}

?>