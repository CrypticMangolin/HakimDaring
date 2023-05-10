<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\Soal;
use App\Core\Soal\Data\TidakMemilikiHakException;

interface InterfaceUbahSoal {

    /**
     * Untuk mengubah isi soal. Yang dimaksud soal ini adalah soalnya saja tanpa testcase
     * 
     * @param IDUser $idUser id dari user yang melakukan perubahan
     * @param Soal $soalBaru soal baru hasil perubahan dari user
     * 
     * @throws TidakMemilikiHakException jika tidak memiliki hak untuk mengubah isi soal
     */
    public function ubahSoal(IDUser $idUser, Soal $soalBaru) : void;
}

?>