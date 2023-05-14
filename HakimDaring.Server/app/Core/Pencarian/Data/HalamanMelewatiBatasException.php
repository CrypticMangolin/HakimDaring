<?php 

namespace App\Core\Pencarian\Data;

use Exception;

class HalamanMelewatiBatasException extends Exception {

    public function __construct(string $message = "Halaman melewati batas")
    {
        parent::__construct($message);
    }
}

?>