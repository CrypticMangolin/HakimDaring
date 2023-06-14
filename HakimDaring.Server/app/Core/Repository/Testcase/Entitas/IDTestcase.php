<?php 

declare(strict_types = 1);
namespace App\Core\Repository\Testcase\Entitas;

use Illuminate\Support\Str;

class IDTestcase {
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