<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

use Illuminate\Support\Str;

class IDComment {

    private string $id;

    public function __construct(
        private IDRuanganComment $idRuanganComment,
        ?string $id)
    {
        $this->id = $id ? $id : Str::uuid()->toString();
    }

    public function ambilID() : string {
        return $this->id;
    }

    public function ambilIDRuangan() : IDRuanganComment {
        return $this->idRuanganComment;
    }
}

?>