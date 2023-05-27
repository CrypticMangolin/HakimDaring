<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

class TestcaseData {

    private IDTestcase $idTestcase;
    private Testcase $testcase;
    private int $urutan;
    private bool $publik;

    public function __construct(IDTestcase $idTestcase, Testcase $testcase, int $urutan, bool $publik)
    {
        $this->idTestcase = $idTestcase;
        $this->testcase = $testcase;
        $this->urutan = $urutan;
        $this->publik = $publik;
    }

    public function ambilIDTestcase() : IDTestcase {
        return $this->idTestcase;
    }

    public function ambilTestcase() : Testcase {
        return $this->testcase;
    }

    public function ambilUrutan() : int {
        return $this->urutan;
    }

    public function apakahSoalPublik() : bool {
        return $this->publik;
    }
}                 

?>