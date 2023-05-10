<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Soal\Data\TidakMemilikiHakException;

interface InterfaceHapusSoal {

    /**
     * Untuk menghapus soal yang dibuat oleh pengguna.
     * 
     * @param IDUser $idUser id dari pembuat soal
     * @param IDSoal $idSoal id dari soal yang akan dihapus
     * 
     * @throws TidakMemilikiHakException bila bukan yang membuat soal
     */
    public function hapusSoal(IDUser $idUser, IDSoal $idSoal) : void;
}


?>