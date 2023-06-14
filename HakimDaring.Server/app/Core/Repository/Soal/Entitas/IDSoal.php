<?php 
declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

use Illuminate\Support\Str;

class IDSoal {
    private string $id;

    public function __construct(?string $id)
    {
        $this->id = $id ? $id : Str::uuid()->toString();
    }

    public function ambilID() : string {
        return $this->id;
    }
}

?>