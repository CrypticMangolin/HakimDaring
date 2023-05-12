<?php

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

use App\Core\Repository\Data\DataSoal;
use App\Core\Repository\Data\IDSoal;
use App\Core\Soal\Data\GagalBuatSoalException;

interface InterfaceBuatSoal {

    /**
     * Untuk membuat soal baru dan mendapatkan ID dari soal yang baru saja dibuat
     * 
     * @param DataSoal $dataSoal Data-data soal yang akan dibuat
     * 
     * @throws GagalBuatSoalException bila gagal membuat soal.
     * 
     * @return IDSoal ID dari soal yang baru saja dibuat
     */
    public function buatSoal(DataSoal $dataSoal) : IDSoal;
}

?>