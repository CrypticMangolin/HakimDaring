<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

class SortBy {
    
    public const SORTBY_ID = 0;
    public const SORTBY_JUDUL = 1;
    public const SORTBY_JUMLAH_SUBMIT = 2;
    public const SORTBY_JUMLAH_BERHASIL = 3;
    public const SORTBY_PERSENTASE_BERHASIL = 4;

    private int $sortby;
    private bool $reverse;

    public function __construct(int $sortby, bool $reverse)
    {
        $this->sortby = $sortby;
        $this->reverse = $reverse;
    }

    public function ambilSortBy() : int {
        return $this->sortby;
    }

    public function apakahReverse() : bool {
        return $this->reverse;
    }
}

?>