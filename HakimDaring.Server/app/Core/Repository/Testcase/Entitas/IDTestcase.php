<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

class IDTestcase {
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function ambilID() : int {
        return $this->id;
    }
}

?>