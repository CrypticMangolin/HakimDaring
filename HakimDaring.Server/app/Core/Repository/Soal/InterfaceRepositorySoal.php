<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\DataSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\InformasiSoal;
use App\Core\Repository\Soal\Entitas\Soal;
use App\Core\Repository\Soal\Entitas\VersiSoal;

interface InterfaceRepositorySoal {

    /**
     * Menyimpan data soal baru ke dalam database
     * 
     * @param IDUser $idUser id pembuat soal
     * @param DataSoal $dataSoal soal yang akan dibuat
     * @param BatasanSoal $batasanSoal batasan untuk soal
     * @param IDRuanganComment $idRuanganComment id ruangan comment untuk diskusi soal
     * 
     * @return IDSoal id dari soal yang dibuat
     */
    public function buatSoal(IDUser $idUSer, DataSoal $dataSoal, BatasanSoal $batasanSoal, IDRuanganComment $idRuanganComment) : IDSoal;

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
     * Untuk mengambil data semua informasi soal
     * 
     * @param IDSoal $idSoal id dari soal yang diambil datanya
     * 
     * @return ?InformasiSoal informasi soal
     */
    public function ambilInformasiSoal(IDSoal $idSoal) : ?InformasiSoal;

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
     * @return ?VersiSoal versi soal
     */
    public function ambilVersiSoal(IDSoal $idSoal) : ?VersiSoal;

    /**
     * Untuk menambah versi soal 
     * 
     * @param IDSoal $idSoal id dari soal yang berubah versinya
     */
    public function tambahVersiSoal(IDSoal $idSoal) : void;

    /**
     * Untuk mengambil batasan sumber daya dari sebuah soal
     * 
     * @param IDSoal $idSoal id dari soal yang akan diambil sumber dayanya
     * 
     * @return ?BatasanSoal batasan sumber daya soal
     */
    public function ambilBatasanSumberDaya(IDSoal $idSoal) : ?BatasanSoal;

    /**
     * Untuk memperbarui batasan soal
     * 
     * @param IDSoal $idSoal id dari soal yang akan diperbarui batasan sumber dayanya
     * @param BatasanSoal $batasanBaru batasan sumber daya baru untuk soal
     */
    public function setBatasanSoal(IDSoal $idSoal, BatasanSoal $batasanBaru) : void;

    /**
     * Untuk menambah jumlah submission dari sebuah soal dan keberhasilan soal
     * 
     * @param IDSoal $idSoal id dari soal submission
     * @param bool $berhasil bernilai true bila submission benar
     */
    public function tambahSubmission(IDSoal $idSoal, bool $benar) : void;
}

?>