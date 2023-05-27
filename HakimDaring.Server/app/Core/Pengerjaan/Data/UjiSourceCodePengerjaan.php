<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Data;

use App\Core\Repository\Testcase\Entitas\Testcase;

class UjiSourceCodePengerjaan {

    /**
     * @param Testcase[] $daftarTestcase
     */
    public function __construct(
        private string $sourceCode,
        private int $bahasa,
        private array $daftarTestcase
    ) {}

    public function ambilSourceCode() : string {
        return $this->sourceCode;
    }

    public function ambilBahasa() : int {
        return $this->bahasa;
    }

    /**
     * @return Testcase[]
     */
    public function ambilDaftarTestcase() : array {
        return $this->daftarTestcase;
    }
}

?>