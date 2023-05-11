<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

class TestcaseData extends Testcase {

    private int $urutan;
    
    private bool $publik;

    public function __construct(string $testcase, string $jawaban, int $urutan, bool $publik)
    {
        parent::__construct($testcase, $jawaban);

        $this->urutan = $urutan;
        $this->publik = $publik;
    }

    public function ambilUrutan() : int {
        return $this->urutan;
    }

    public function apakahSoalPublik() : bool {
        return $this->publik;
    }
}                 

?>