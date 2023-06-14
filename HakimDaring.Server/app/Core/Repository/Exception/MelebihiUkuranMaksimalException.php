<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Exception;

use Exception;

class MelebihiUkuranMaksimalException extends Exception {

    public function __construct(string $message = "Melebihi ukuran maksimal")
    {
        parent::__construct($message);
    }
}

?>