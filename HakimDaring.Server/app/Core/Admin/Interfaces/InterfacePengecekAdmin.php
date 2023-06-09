<?php 

declare(strict_types = 1);

namespace App\Core\Admin\Interfaces;

use App\Core\Repository\Autentikasi\Entitas\IDUser;

interface InterfacePengecekAdmin {

    public function cekApakahAdmin(IDUser $idUser) : bool;
}

?>