<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\InterfaceRepositorySoal;
use App\Core\Soal\Data\TidakMemilikiHakException;
use App\Core\Soal\Interface\InterfaceHapusSoal;
use App\Core\Soal\Interface\InterfacePengecekPembuatSoal;
use InvalidArgumentException;

class HapusSoal implements InterfaceHapusSoal {

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

    public function hapusSoal(IDUser $idUser, IDSoal $idSoal): void
    {
        
        if(!$this->pengecekPembuatSoal->cekApakahUserYangMembuatSoal($idUser, $idSoal)) {
            throw new TidakMemilikiHakException();
        }
        
        $this->repositorySoal->hapusSoal($idSoal);
    }
}

?>