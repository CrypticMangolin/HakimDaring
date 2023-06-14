<?php 

declare(strict_types = 1);

namespace App\Application\Query\Pencarian;

class HasilPencarianDTO {

    /**
     * @param HasilPencarianSoalDTO[] $hasilPencarian
     */
    public function __construct(
        public int $halaman,
        public int $totalHalaman,
        public array $hasilPencarian
    )
    {

    }
}

?>