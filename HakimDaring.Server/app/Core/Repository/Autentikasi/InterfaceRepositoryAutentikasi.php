<?php 

declare(strict_types=1);

namespace App\Core\Repository\Autentikasi;

interface InterfaceRepositoryAutentikasi {

    /**
     * Untuk menyimpan data akun baru dalam database
     * 
     * @param string $nama nama akun
     * @param string $email email akun
     * @param string $password password akun
     * 
     * @return bool akun berhasil dibuat
     */
    public function buatAkun(string $nama, string $email, string $password) : bool;

    /**
     * Untuk mengecek apakah email belum dipakai sama sekali
     * oleh akun yang sudah ada
     * 
     * @param string $email Email akun yang akan dicari
     */
    public function cekEmailBelumDipakai(string $email) : bool;

    
}

?>