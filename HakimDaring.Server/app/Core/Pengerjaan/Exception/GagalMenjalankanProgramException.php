<?php 

namespace App\Core\Pengerjaan\Exception;

use Exception;

class GagalMenjalankanProgramException extends Exception {

    public function __construct(string $message = "Gagal Menjalankan Program")
    {
        parent::__construct($message);
    }
}

?>