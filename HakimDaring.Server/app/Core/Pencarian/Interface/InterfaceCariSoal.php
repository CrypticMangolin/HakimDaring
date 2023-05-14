<?php 

declare(strict_types = 1);

namespace App\Core\Pencarian\Interface;

use App\Core\Repository\Data\HasilPencarian;
use App\Core\Repository\Data\KategoriPencarian;

interface InterfaceCariSoal {

    /**
     * Untuk mengambil kumpulan soal dan total halaman yang memenuhi syarat-syarat pencarian
     * 
     * @param int $halaman halaman pencarian yang dibuka
     * @param KategoriPencarian $kategoriPencarian syarat-syarat pencarian
     * 
     * @return HasilPencarian hasil pencarian
     */
    public function cariSoal(int $halaman, KategoriPencarian $kategoriPencarian) : HasilPencarian;
}

?>