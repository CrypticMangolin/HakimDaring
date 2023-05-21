<?php 

declare(strict_types = 1);

namespace App\Core\Admin\Interface;

use App\Core\Repository\Data\IDUser;

interface InterfacePengecekAdmin {

    public function cekApakahAdmin(IDUser $idUser) : bool;
}

?>