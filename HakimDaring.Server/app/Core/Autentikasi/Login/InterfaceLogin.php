<?php 
declare(strict_types=1);

namespace App\Core\Autentikasi\Login;

use App\Core\Autentikasi\Login\Data\GagalLoginException;

interface InterfaceLogin {

    /**
     * Untuk melakukan login berdasarkan nama dan password
     * 
     * @param string $email adalah email identitas akun
     * @param string $password adalah password akun
     * 
     * @throws GagalLoginException bila gagal melakukan login
     * 
     * @return string token autentikasi
     */
    public function login(string $email, string $password) : string;
}

?>