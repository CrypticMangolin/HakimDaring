<?php 

declare(strict_types = 1);

namespace App\Application\Command\Autentikasi\Register;

class RequestRegister {

    public function __construct(
        public string $email,
        public string $password,
        public string $ulangiPassword,
        public string $nama,
    )
    {
        
    }
}

?>