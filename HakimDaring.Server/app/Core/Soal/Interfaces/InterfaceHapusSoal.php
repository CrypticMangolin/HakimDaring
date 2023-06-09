<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interfaces;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;

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