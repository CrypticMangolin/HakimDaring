<?php 

namespace App\Core\Soal\Exception;

use Exception;

class TidakMemilikiHakException extends Exception {

    public function __construct(string $message = "Tidak memiliki hak")
    {
        parent::__construct($message);
    }
}

?>