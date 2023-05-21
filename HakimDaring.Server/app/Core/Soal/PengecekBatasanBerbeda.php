<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Soal\Interface\InterfacePengecekBatasanBerbeda;
use InvalidArgumentException;

class PengecekBatasanBerbeda implements InterfacePengecekBatasanBerbeda {

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(InterfaceRepositorySoal $repositorySoal)
    {
        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal bernilai null");
        }
        $this->repositorySoal = $repositorySoal;
    }

    public function cakApakahBatasanBerbeda(IDSoal $idSoal, BatasanSoal $batasanBaru) : bool {
        return $this->repositorySoal->ambilBatasanSumberDaya($idSoal) != $batasanBaru;
    }
}

?>