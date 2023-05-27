<?php 

namespace App\Core\Pengerjaan\Exception;

use Exception;

class GagalSubmitProgramException extends Exception {

    public function __construct(string $message = "Gagal Submit Soal")
    {
        parent::__construct($message);
    }
}

?>