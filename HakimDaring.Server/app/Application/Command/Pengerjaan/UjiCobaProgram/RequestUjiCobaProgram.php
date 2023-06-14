<?php 

declare(strict_types = 1);

namespace App\Application\Command\Pengerjaan\UjiCobaProgram;

class RequestUjiCobaProgram {

    public function __construct(
        public string $idSoal,
        public string $sourceCode,
        public string $bahasa,
        public array $daftarInput
    )
    {
        
    }
}

?>