<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Autentikasi\Entitas;

use Carbon\Exceptions\InvalidFormatException;

class Email {

    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidFormatException("format email salah");
        }

        $this->email = $email;
    }

    public function ambilEmail() : string {
        return $this->email;
    }
}

?>