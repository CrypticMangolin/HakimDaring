<?php 

declare(strict_types = 1);

namespace App\Application\Command\Pengerjaan\SubmitPengerjaan;

class RequestSubmitPengerjaan {

    public function __construct(
        public string $idSoal,
        public string $sourceCode,
        public string $bahasa
    )
    {
        
    }
}

?>