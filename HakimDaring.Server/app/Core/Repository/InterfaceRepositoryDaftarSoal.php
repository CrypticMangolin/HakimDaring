<?php 

declare(strict_types = 1);

namespace App\Core\Repository;

use App\Core\Repository\Data\DaftarSoal;
use Pencarian;


interface InterfaceRepositoryDaftarSoal {
    
    const JUMLAH_PERHALAMAN = 10;
    
    /**
     * Untuk mengambil daftar soal berdasarkan halaman (pagination),
     * satu halaman bernilai InterfaceRepositoryDaftarSoal::JUMLAH_PERHALAMAN soal
     * 
     * @param int $halaman halaman yang akan diambil data-datanya
     * @param string 
     * 
     * @return DaftarSoal[] daftar soal-soal pada halaman tersebut
     */
    public function ambilDaftarSoalHalaman(int $halaman, Pencarian $syaratPencarian) : array;

    public function ambilTotalHalaman() : int;
}

?>