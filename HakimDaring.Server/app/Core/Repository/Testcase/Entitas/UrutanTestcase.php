<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

class UrutanTestcase {

    private int $urutan;

    /**
     * untuk menyimpan urutan testcase
     * 
     * @param int $urutan urutan testcase
     */
    public function __construct(int $urutan)
    {
        $this->urutan = $urutan;
    }

    /**
     * Untuk mengambil urutan testcase
     * 
     * @return int urutan testcase
     */
    public function ambilUrutan() : int {
        return $this->urutan;
    }
}                 

?>