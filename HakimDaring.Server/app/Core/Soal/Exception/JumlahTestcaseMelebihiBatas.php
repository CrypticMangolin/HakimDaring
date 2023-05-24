<?php 

namespace App\Core\Soal\Exception;

use Exception;

class JumlahTestcaseMelebihiBatas extends Exception {

    public function __construct(string $message = "Jumlah Testcase Melebihi Batas")
    {
        parent::__construct($message);
    }
}

?>