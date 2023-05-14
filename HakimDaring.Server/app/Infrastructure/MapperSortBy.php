<?php 

declare(strict_types = 1);

namespace App\Infrastructure;

use App\Core\Repository\Data\SortBy;

class MapperSortBy {

    private array $mapper = [
        SortBy::SORTBY_ID => "id",
        SortBy::SORTBY_JUDUL => "judul",
        SortBy::SORTBY_JUMLAH_SUBMIT => "jumlah_submit",
        SortBy::SORTBY_JUMLAH_BERHASIL => "jumlah_berhasil",
        SortBy::SORTBY_PERSENTASE_BERHASIL => "persentase_berhasil"
    ];
    
    function mapSortBy(SortBy $sortby) : string {
        return $this->mapper[$sortby->ambilSortBy()];
    }
}

?>