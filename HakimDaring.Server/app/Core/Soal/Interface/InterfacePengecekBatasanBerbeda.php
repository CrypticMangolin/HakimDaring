<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;

interface InterfacePengecekBatasanBerbeda {

    /**
     * Untuk mengecek apakah batasan sumber daya yang diberikan untuk soal berbeda
     * 
     * @param IDSoal $idSoal id dari soal yang akan dibandingkan
     * @param BatasanSoal $batasanBaru batsan sumber daya yang baru
     * 
     * @throws InvalidArgumentException bila pada array mengandung object yang bukan object Testcase
     * 
     * @return bool true bila berbeda
     */
    public function cakApakahBatasanBerbeda(IDSoal $idSoal, BatasanSoal $batasanBaru) : bool;
}

?>