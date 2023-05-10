<?php 

declare(strict_types = 1);

namespace App\Core\Repository;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\Soal;

interface InterfaceRepositorySoal {

    /**
     * Menyimpan data soal baru ke dalam database
     * 
     * @param IDUser $idUser id pembuat soal
     * @param string $judul Judul soal
     * @param string $soal Isi soal
     * 
     * @return IDSoal id dari soal yang dibuat
     */
    public function buatSoal(IDUser $idUSer, string $judul, string $soal) : IDSoal;

    /**
     * Untuk mengecek apakah judul soal sudah pernah dipakai
     * 
     * @param string $judul judul soal yang akan dicek
     * 
     * @return bool bernilai benar bila telah dipakai sebelumnya
     */
    public function cekApakahJudulSudahDipakai(string $judul) : bool;

    /**
     * Untuk menghapus soal sesuai dengan id nya
     * 
     * @param IDSoal $idSoal id dari soal yang akan dihapus
     */
    public function hapusSoal(IDSoal $idSoal) : void;

    
    /**
     * Untuk mengubah isi soal tertentu
     * 
     * @param Soal $soal data soal baru
     */
    public function ubahSoal(Soal $soal) : void;

    /**
     * Untuk mengambil ID user yang membuat soal
     * 
     * @param IDSoal $idSoal id dari soal yang akan diambil datanya
     * 
     * @return ?IDUser id dari user yang membuat soal
     */
    public function ambilIDPembuatSoal(IDSoal $idSoal) : ?IDUser;

    /**
     * Untuk mengambil versi dari sebuah soal
     * 
     * @param IDSoal $idSoal id dari soal yang akan diambil versinya
     * 
     * @return ?int versi soal
     */
    public function ambilVersiSoal(IDSoal $idSoal) : ?int;

    /**
     * Untuk menambah versi soal 
     * 
     * @param IDSoal $idSoal id dari soal yang berubah versinya
     */
    public function tambahVersiSoal(IDSoal $idSoal) : void;
}

?>