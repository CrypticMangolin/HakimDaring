<?php 

declare(strict_types = 1);

namespace App\Core\Repository;

use App\Core\Repository\Data\HasilPencarianSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\KategoriPencarian;

interface InterfaceRepositoryDaftarSoal {
    
    public const JUMLAH_PERHALAMAN = 10;
    
    /**
     * Untuk mengambil daftar soal berdasarkan halaman (pagination),
     * satu halaman bernilai InterfaceRepositoryDaftarSoal::JUMLAH_PERHALAMAN soal
     * 
     * @param int $halaman halaman yang akan diambil data-datanya
     * @param KategoriPencarian $syaratPencarian syarat-syarat pencarian
     * 
     * @return HasilPencarianSoal[] daftar soal-soal pada halaman tersebut
     */
    public function ambilDaftarSoalHalaman(int $halaman, KategoriPencarian $syaratPencarian) : array;

    /**
     * Untuk mengambil jumlah halaman yang memenuhi kategori. Halaman berasal dari jumlah
     * data yang memenuhi kategori dan dibagi dengan JUMLAH_PERHALAMAN
     * 
     * @param KategoriPencarian $syaratPencarian syarat-syarat pencarian yang harus terpenuhi
     * 
     * @return int halaman yang ada
     */
    public function ambilTotalHalaman(KategoriPencarian $syaratPencarian) : int;
}

?>