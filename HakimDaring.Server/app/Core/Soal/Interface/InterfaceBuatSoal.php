<?php

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\DataSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;

interface InterfaceBuatSoal {

    /**
     * Untuk membuat soal baru dan mendapatkan ID dari soal yang baru saja dibuat
     * 
     * @param IDUser $idUser id pembuat soal
     * @param DataSoal $dataSoal Data-data soal yang akan dibuat
     * 
     * @throws GagalBuatSoalException bila gagal membuat soal.
     * 
     * @return IDSoal ID dari soal yang baru saja dibuat
     */
    public function buatSoal(IDUser $idUser, DataSoal $dataSoal) : IDSoal;
}

?>