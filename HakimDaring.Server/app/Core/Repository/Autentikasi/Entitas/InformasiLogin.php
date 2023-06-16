<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Autentikasi\Entitas;

class InformasiLogin {

    public function __construct(
        private string $token,
        private string $nama,
        private IDUser $idUser
    )
    {
        
    }

    public function ambilToken() : string {
        return $this->token;
    }

    public function ambilNama() : string {
        return $this->nama;
    }

    public function ambilIDUser() : IDUser {
        return $this->idUser;
    }

}

?>