<?php 

declare(strict_types=1);

namespace App\Core\Autentikasi\Register\Interface;

use App\Core\Autentikasi\Register\Data\GagalRegisterException;

interface InterfaceRegister {

    /**
     * Untuk meregister akun baru
     * 
     * @param string $nama nama akun
     * @param string $email email akun
     * @param string $password sandi akun akun
     * @param string $ulangiPassword pengecekan password yang dimasukkan sesuai'
     * 
     * @throws GagalRegisterException bila gagal melakukan register
     * 
     * @return bool keberhasilan registrasi
     */
    public function register(string $nama, string $email, string $password, string $ulangiPassword) : bool;
}

?>