<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

use App\Core\Repository\Testcase\Entitas\TestcaseData;

class TestcaseDataSubmit {

    private IDTestcase $idTestcase;
    private TestcaseData $dataTestcase;
    
    public function __construct(IDTestcase $idTestcase, TestcaseData $dataTestcase)
    {
        $this->idTestcase = $idTestcase;
        $this->dataTestcase = $dataTestcase;
    }

    public function ambilIDTestcase() : IDTestcase {
        return $this->idTestcase;
    }

    public function ambilDataTestcase() : TestcaseData {
        return $this->dataTestcase;
    }
}                 

?>