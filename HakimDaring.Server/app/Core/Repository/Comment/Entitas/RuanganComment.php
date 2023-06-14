<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use DateTime;

class RuanganComment {

    public function __construct(
        private IDRuanganComment $id,
        private IDUser $pembuat,
    ) {}

    public function ambilIDRuangan() : IDRuanganComment {
        return $this->id;
    }

    public function ambilPembuat() : IDUser {
        return $this->pembuat;
    }

    public function tambahComment(
        IDUser $idPenulis, IsiComment $isiComment, DateTime $tanggalPenulisan, ?IDComment $reply, StatusComment $status
    ) : Comment {
        return new Comment(
            new IDComment($this->id, null),
            $idPenulis,
            $isiComment,
            $tanggalPenulisan,
            $reply,
            $status
        );
    }
}

?>