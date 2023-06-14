<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Autentikasi\Entitas;

class Akun {

    public function __construct(
        private Email $email,
        private string $password
    )
    {
        
    }

    public function ambilEmail() : Email {
        return $this->email;
    }

    public function ambilPassword() : string {
        return $this->password;
    }

}

?>