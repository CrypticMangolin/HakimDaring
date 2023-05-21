<?php 

namespace App\Core\Soal\Exception;

use Exception;

class GagalBuatSoalException extends Exception {

    public function __construct(string $message = "Gagal Buat Soal")
    {
        parent::__construct($message);
    }
}

?>