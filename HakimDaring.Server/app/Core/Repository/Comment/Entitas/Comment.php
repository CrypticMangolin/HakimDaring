<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\InformasiUser\Entitas\InformasiUser;
use DateTime;

class Comment {

    public function __construct(
        private IDComment $id,
        private IDUser $idPenulis,
        private IsiComment $isiComment,
        private DateTime $tanggalPenulisan,
        private ?IDComment $reply,
        private StatusComment $status
    ) {}

    public function ambilID() : IDComment {
        return $this->id;
    }

    public function ambilIDPenulis() : IDUser {
        return $this->idPenulis;
    }

    public function ambilIsiComment() : IsiComment {
        return $this->isiComment;
    }

    public function ambilTanggalPenulisan() : DateTime {
        return $this->tanggalPenulisan;
    }

    public function ambilReply() : ?IDComment {
        return $this->reply;
    }

    public function ambilStatusComment() : StatusComment {
        return $this->status;
    }
}

?>