<?php 

declare(strict_types = 1);

namespace App\Core\Repository\DaftarSoal\Entitas;

class KategoriPencarian {
    private string $kataKunciJudul;
    private SortBy $sortBy;

    public function __construct(string $kataKunciJudul, SortBy $sortBy)
    {
        $this->kataKunciJudul = $kataKunciJudul;
        $this->sortBy = $sortBy;
    }

    public function ambilKataKunciJudul() : string {
        return $this->kataKunciJudul;
    }

    public function ambilSortBy() : SortBy {
        return $this->sortBy;
    }
}

?>