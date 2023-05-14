<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

class HasilPencarian {
    private int $halaman;
    private int $totalHalaman;
    private array $hasilPencarian;

    public function __construct(int $halaman, int $totalHalaman, array $hasilPencarian) {
        $this->halaman = $halaman;
        $this->totalHalaman = $totalHalaman;
        $this->hasilPencarian = $hasilPencarian;
    }

    public function ambilHalaman() : int {
        return $this->halaman;;
    }

    public function ambilTotalHalaman() : int {
        return $this->totalHalaman;
    }

    /**
     * @return HasilPencarianSoal[]
     */
    public function ambilHasilPencarian() : array {
        return $this->hasilPencarian;
    }
}

?>