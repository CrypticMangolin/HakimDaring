<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

class PublisitasTestcase {


    const PUBLIK = "publik";
    const PRIVATE = "private";

    private string $publik;

    /**
     * untuk menyimpan publisitas testcase testcase (apakah publik atau private)
     * 
     * @param string $urutan urutan testcase
     */
    public function __construct(string $publik)
    {
        $this->publik = $publik;
    }

    /**
     * Untuk mengambil publisitas testcase
     * 
     * @return string publik testcase
     */
    public function ambilpublisitas() : string {
        return $this->publik;
    }
}                 

?>