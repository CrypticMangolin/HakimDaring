<?php 
declare(strict_types = 1);

namespace App\Core\Repository\Autentikasi\Entitas;

class IDUser {
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function ambilID() : string {
        return $this->id;
    }
}

?>