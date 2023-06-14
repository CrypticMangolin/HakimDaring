<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

class SourceCodePengerjaan {

    public function __construct(
        private string $sourceCode,
        private string $bahasa
    ) {
        
    }

    public function ambilSourceCode() : string {
        return $this->sourceCode;
    }

    public function ambilBahasa() : string {
        return $this->bahasa;
    }
}

?>