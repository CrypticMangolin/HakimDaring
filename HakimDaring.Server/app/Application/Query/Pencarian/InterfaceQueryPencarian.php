<?php 

declare(strict_types = 1);

namespace App\Application\Query\Pencarian;

interface InterfaceQueryPencarian {
    
    const JUMLAH_PERHALAMAN = 20;

    public function cariSoal(int $halaman, string $judul, string $sortBy, bool $reverse) : HasilPencarianDTO;
}

?>