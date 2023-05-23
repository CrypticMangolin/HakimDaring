<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use DateTime;

class Comment {

    public function __construct(
        private IDComment $id,
        private DataComment $dataComment
    ) {}

    public function ambilID() : IDComment {
        return $this->id;
    }

    public function ambilDataComment() : DataComment {
        return $this->dataComment;
    }
}

?>