<?php 

namespace App\Core\Soal\Data;

use Exception;

class TestcaseDuplikatException extends Exception {

    public function __construct(string $message = "Terdapat Testcase Duplikat")
    {
        parent::__construct($message);
    }
}

?>