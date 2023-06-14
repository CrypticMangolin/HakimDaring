<?php 

declare(strict_types = 1);

namespace App\Application\Command\Autentikasi\Login;

class RequestLogin {

    public function __construct(
        public string $email,
        public string $password
    )
    {
        
    }
}

?>