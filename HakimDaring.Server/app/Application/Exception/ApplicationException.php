<?php 

namespace App\Application\Command\Soal\Exception;

use Exception;

class ApplicationException extends Exception {

    public function __construct(string $message = "error")
    {
        parent::__construct($message);
    }
}

?>