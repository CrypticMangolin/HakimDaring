<?php 

declare(strict_types = 1);

namespace App\Core\Repository\DataUser\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;

class DataUser {

    private IDUser $idUser;
    private string $kelompok;

    public function __construct(IDUser $idUser, string $kelompok)
    {
        $this->idUser = $idUser;
        $this->kelompok = $kelompok;
    }

    public function ambilIDUser() : IDUser {
        return $this->idUser;
    }

    public function ambilKelompok() : string {
        return $this->kelompok;
    }
}

?>