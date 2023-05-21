<?php 

declare(strict_types = 1);

namespace App\Core\Repository\DataUser;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\DataUser\Entitas\DataUser;

interface InterfaceRepositoryDataUser {

    /**
     * Untuk mengambil data user dari ID nya
     * 
     * @param IDUser $idUser id dari user yang diambil datanya
     * 
     * @return DataUser data user tersebut
     */
    public function ambilDataUser(IDUser $idUser) : DataUser;
}

?>