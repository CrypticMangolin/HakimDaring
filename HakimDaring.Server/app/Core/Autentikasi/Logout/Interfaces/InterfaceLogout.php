<?php 

declare(strict_types = 1);

namespace App\Core\Autentikasi\Logout\Interfaces;

interface InterfaceLogout {

    /**
     * Untuk logout dan menghapus token yang diberikan kepada
     * pengguna
     */
    public function logout() : void;
}

?>