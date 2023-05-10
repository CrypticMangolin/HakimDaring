<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interface;

interface InterfacePengecekTestcaseDuplikat {

    /**
     * Untuk mengecek apakah setiap testcase unik berdasarkan inputnya
     * 
     * @param array $grupTestcase array kumpulan testcase
     * 
     * @throws InvalidArgumentException bila pada array mengandung object yang bukan object Testcase
     * 
     * @return bool true bila ada duplikat, false bila tidak ada duplikat
     */
    public function cekApakahTestcaseDuplikat(array $grupTestcase) : bool;
}

?>