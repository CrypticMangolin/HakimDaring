<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

class JawabanTestcase {
    private string $jawaban;

    /**
     * Untuk menyimpan jawaban testcase
     * 
     * @param string $testcase jawaban soal
     */
    public function __construct(string $jawaban)
    {
        $this->jawaban = $jawaban;
    }

    /**
     * Untuk mengambil jawaban testcase
     * 
     * @return string jawaban testcase
     */
    public function ambilJawaban() : string {
        return $this->jawaban;
    }
}

?>