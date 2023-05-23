<?php 

namespace App\Core\Comment\Exception;

use Exception;

class GagalMembuatKomentarException extends Exception {

    public function __construct(string $message = "Gagal Membuat Komentar")
    {
        parent::__construct($message);
    }
}

?>