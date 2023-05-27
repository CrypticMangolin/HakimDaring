<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan;

use App\Core\Repository\Pengerjaan\Entitas\DataPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\IDPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\Pengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\PengerjaanTestcase;

interface InterfaceRepositoryPengerjaan {

    /**
     * Untuk menyimpan data pengerjaan user
     * 
     * @param DataPengerjaan $dataPengerjaan data pengerjaan user yang akan disimpan
     * 
     * @return IDPengerjaan id dari data pengerjaan
     */
    public function simpanPengerjaan(DataPengerjaan $dataPengerjaan) : IDPengerjaan;

    /**
     * Untuk mengambil data pengerjaan user
     * 
     * @param IDPengerjaan $iDPengerjaan id dari pengerjaan
     * 
     * @return ?Pengerjaan data pengerjaan
     */
    public function ambilPengerjaan(IDPengerjaan $iDPengerjaan) : ?Pengerjaan;

    /**
     * Untuk menyimpan hasil uji testcase dari sebuah pengerjaan
     * 
     * @param PengerjaanTestcase[]  $daftarPengerjaanTestcase hasil testcase
     */
    public function simpanPengerjaanTestcase(array $daftarPengerjaanTestcase) : void;

    /**
     * Untuk mengambil hasil uji testcase dari sebuah pengerjaan
     * 
     * @param IDPengerjaan $idPengerjaan id dari pengerjaan
     * 
     * @return PengerjaanTestcase[] daftar hasil testcase
     */
    public function ambilPengerjaanTestcase(IDPengerjaan $idPengerjaan) : array;
}

?>