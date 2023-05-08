<?php

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\IDSoal;
use App\Core\Soal\Data\GagalBuatSoalException;

interface InterfaceBuatSoal {

    /**
     * Untuk membuat soal baru dan mendapatkan ID dari soal yang baru saja dibuat
     * 
     * @param string $judul Judul soal yang dibuat
     * @param string $soal Isi soal dalam bentuk string
     * 
     * @throws GagalBuatSoalException bila gagal membuat soal.
     * 
     * @return IDSoal ID dari soal yang baru saja dibuat
     */
    public function buatSoal(string $judul, string $soal) : IDSoal;
}

?>