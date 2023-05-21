<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

use InvalidArgumentException;

class Testcase {
    private string $testcase;
    private string $jawaban;

    /**
     * Untuk menyimpan data testcase
     * 
     * @param string $testcase Testcase soal
     * @param string $jawaban Jawaban dari testcase
     */
    public function __construct(string $testcase, string $jawaban)
    {
        if ($testcase == null) {
            throw new InvalidArgumentException("Argument null");
        }
        
        if ($jawaban == null) {
            throw new InvalidArgumentException("Argument null");
        }

        $this->testcase = $testcase;
        $this->jawaban = $jawaban;
    }

    /**
     * Untuk mengambil testcase (soal)
     * 
     * @return string soal testcase
     */
    public function ambilTestcase() : string {
        return $this->testcase;
    }

    /**
     * Untuk mengambil jawaban dari testcase
     * 
     * @return string jawaban testcase
     */
    public function ambilJawaban() : string {
        return $this->jawaban;
    }
}

?>