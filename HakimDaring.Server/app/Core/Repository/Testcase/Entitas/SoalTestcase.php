<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

class SoalTestcase {
    private string $testcase;

    /**
     * Untuk menyimpan soal testcase
     * 
     * @param string $testcase soal testcase
     */
    public function __construct(string $testcase)
    {
        $this->testcase = $testcase;
    }

    /**
     * Untuk mengambil soal testcase
     * 
     * @return string soal testcase
     */
    public function ambilSoal() : string {
        return $this->testcase;
    }
}

?>