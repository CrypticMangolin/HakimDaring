<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;

interface InterfacePengecekPembuatSoal {

    /**
     * Untuk mengecek apakah user yang membuat soal
     * 
     * @param IDUser $idUser id dari user yang akan di cek
     * @param IDSoal $idSoal id dari soal yang akan di cek
     * 
     * @return bool bernilai benar jika user yang membuat soal tersebut 
     */
    public function cekApakahUserYangMembuatSoal(IDUser $idUser, IDSoal $idSoal) : bool;
}

?>