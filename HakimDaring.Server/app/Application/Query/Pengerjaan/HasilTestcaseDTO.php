<?php 

declare(strict_types = 1);

namespace App\Application\Query\Pengerjaan;

class HasilTestcaseDTO {

    public function __construct(
        public string $status,
        public float $waktu,
        public int $memori
    )
    {

    }
}

?>