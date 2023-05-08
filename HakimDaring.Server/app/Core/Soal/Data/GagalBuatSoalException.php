<?php 

namespace App\Core\Soal\Data;

use Exception;

class GagalBuatSoalException extends Exception {

    public function __construct(string $message = "Gagal Buat Soal")
    {
        parent::__construct($message);
    }
}

?>