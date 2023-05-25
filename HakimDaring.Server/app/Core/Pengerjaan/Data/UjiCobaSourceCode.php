<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Data;

class UjiCobaSourceCode {

    public function __construct(
        private string $sourceCode,
        private int $bahasa,
        private array $stdin
    ) {}

    public function ambilSourceCode() : string {
        return $this->sourceCode;
    }

    public function ambilBahasa() : int {
        return $this->bahasa;
    }

    public function ambilDaftarInput() : array {
        return $this->stdin;
    }
}

?>