<?php 

declare(strict_types = 1);

namespace App\Core\Repository;

interface InterfaceRepositorySoal {

    /**
     * Menyimpan data soal baru ke dalam database
     * 
     * @param string $judul Judul soal
     * @param string $soal Isi soal
     * 
     * 
     */
    public function buatSoal(string $judul, string $soal) : IDSoal;
}

?>