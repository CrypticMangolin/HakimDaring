<?php 
declare(strict_types=1);

namespace App\Core\Autentikasi\Login\Data;

use Exception;

class GagalLoginException extends Exception {

    public function __construct(string $message = "Error login")
    {
        parent::__construct($message);
    }
}

?>