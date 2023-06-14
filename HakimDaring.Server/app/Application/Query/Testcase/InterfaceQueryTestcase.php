<?php 

declare(strict_types = 1);

namespace App\Application\Query\Testcase;

interface InterfaceQueryTestcase {

    /**
     * @return TestcaseDTO[]
     */
    public function ambilTestcasePublik(string $idSoal) : array;

    /**
     * @return TestcaseDTO[]
     */
    public function ambilSemuaTestcase(string $idSoal) : array;
}

?>