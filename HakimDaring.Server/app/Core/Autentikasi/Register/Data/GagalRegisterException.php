<?php 
declare(strict_types=1);

namespace App\Core\Autentikasi\Register\Data;

use Exception;

class GagalRegisterException extends Exception {

    public function __construct(string $message = "Error register")
    {
        parent::__construct($message);
    }
}

?>