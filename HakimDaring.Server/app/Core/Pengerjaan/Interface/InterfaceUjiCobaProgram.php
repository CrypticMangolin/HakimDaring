<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Interface;

use App\Core\Pengerjaan\Data\HasilSubmission;
use App\Core\Repository\Pengerjaan\Entitas\UjiCobaSourceCode;

interface InterfaceUjiCobaProgram {

    /**
     * Untuk mencoba menjalankan source code untuk beberapa input
     * 
     * @param UjiCobaSourceCode $sourceCode source code yang akan di uji coba beserta input dari pengguna
     * 
     * @return HasilSubmission[] hasil dari submission
     */
    public function ujiCobaJalankanProgram(UjiCobaSourceCode $sourceCode) : array;
}

?>