<?php 

namespace App\Core\Soal;

use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\InterfaceRepositorySoal;
use App\Core\Soal\Interface\InterfacePengecekPembuatSoal;
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