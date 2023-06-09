<?php 

namespace App\Core\Soal;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Soal\Interfaces\InterfacePengecekPembuatSoal;
use InvalidArgumentException;

class PengecekPembuatSoal implements InterfacePengecekPembuatSoal {

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(InterfaceRepositorySoal $repositorySoal)
    {
        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal null");
        }
        $this->repositorySoal = $repositorySoal;
    }

    public function cekApakahUserYangMembuatSoal(IDUser $idUser, IDSoal $idSoal): bool
    {
        $idUserPembuatSoalSebenarnya = $this->repositorySoal->ambilIDPembuatSoal($idSoal);
        if ($idUserPembuatSoalSebenarnya == null) {
            return false;
        }
        return $idUserPembuatSoalSebenarnya == $idUser;
    }
}

?>