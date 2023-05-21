<?php 
declare(strict_types=1);

namespace App\Core\Autentikasi\Register\Exception;

use Exception;

class GagalRegisterException extends Exception {

    public function __construct(string $message = "Gagal register")
    {
        parent::__construct($message);
    }
}

?>