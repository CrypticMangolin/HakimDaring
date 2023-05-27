<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Interface;

use App\Core\Pengerjaan\Data\HasilSubmission;
use App\Core\Pengerjaan\Data\UjiCobaSourceCode;
use App\Core\Repository\Soal\Entitas\IDSoal;

interface InterfaceUjiCobaProgram {

    /**
     * Untuk mencoba menjalankan source code untuk beberapa input
     * 
     * @param IDSoal $idSoal id soal yang dicoba programnya
     * @param UjiCobaSourceCode $sourceCode source code yang akan di uji coba beserta input dari pengguna
     * 
     * @return HasilSubmission[] hasil dari submission
     * 
     * @throws GagalMenjalankanProgramException bila gagal menjalankan program
     */
    public function ujiCobaJalankanProgram(IDSoal $idSoal, UjiCobaSourceCode $sourceCode) : array;
}

?>