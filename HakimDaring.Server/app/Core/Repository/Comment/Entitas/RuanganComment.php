<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;

class RuanganComment {

    public function __construct(
        private IDRuanganComment $id,
        private IDUser $pembuat
    ) {}

    public function ambilPembuat() : IDUser {
        return $this->pembuat;
    }
}

?>