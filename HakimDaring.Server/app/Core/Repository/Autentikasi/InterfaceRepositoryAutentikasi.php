<?php 

declare(strict_types=1);

namespace App\Core\Repository\Autentikasi;

use App\Core\Repository\Autentikasi\Entitas\Akun;
use App\Core\Repository\Autentikasi\Entitas\IDUser;

interface InterfaceRepositoryAutentikasi {

    public function buatAkun(Akun $akun) : IDUser;

    
}

?>