<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Interface;

use App\Core\Pengerjaan\Data\PengerjaanSourceCode;
use App\Core\Pengerjaan\Exception\GagalSubmitProgramException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Pengerjaan\Entitas\IDPengerjaan;

interface InterfaceSubmitPengerjaanProgram {

    /**
     * Untuk submit pengerjaan dari sebuah soal
     * 
     * @param PengerjaanSourceCode $pengerjaanSourceCode pengerjaan yang disubmit oleh user
     * 
     * @return IDPengerjaan id dari submit pengerjaan baru milik user
     * 
     * @throws GagalSubmitProgramException bila gagal melakukan submit
     */
    public function submitProgram(PengerjaanSourceCode $pengerjaanSourceCode) : IDPengerjaan;
}

?>