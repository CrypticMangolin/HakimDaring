<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;

interface InterfacePengecekBatasan {

    public const WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON = 10.0;
    public const WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON = 20.0;
    public const MEMORI_MAKSIMAL_DALAM_KB = 128000;

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
    public function cekApakahBatasanBerbeda(IDSoal $idSoal, BatasanSoal $batasanBaru) : bool;

    /**
     * Untuk mengecek apakah batasan sumber daya yang diberikan memenuhi syarat
     * 
     * @param BatasanSoal $batasan
     * 
     * @throws InvalidArgumentException bila tidak memenuhi syarat
     * 
     * @return bool bernilai true bila memenuhi syarat
     */
    public function cekApakahBatasanMemenuhiSyarat(BatasanSoal $batasan) : void;
}

?>