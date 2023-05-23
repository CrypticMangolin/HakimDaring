<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

class IDComment {

    public function __construct(private int $id)
    {
        
    }

    public function ambilID() : int {
        return $this->id;
    }
}

?>