<?php 
declare(strict_types = 1);

namespace App\Core\Repository\Data;

class IDSoal {
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