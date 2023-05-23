<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use DateTime;

class CommentBaru {

    public function __construct(
        private IDRuanganComment $idRuangan,
        private IDUser $idUser,
        private string $pesan,
        private DateTime $tanggalPenulisan,
        private ?IDComment $reply,
        private string $status
    ) {}

    public function ambilIDRuangan() : IDRuanganComment {
        return $this->idRuangan;
    }

    public function ambilIDPenulis() : IDUser {
        return $this->idUser;
    }

    public function ambilPesan() : string {
        return $this->pesan;
    }

    public function ambilTanggalPenulisan() : DateTime {
        return $this->tanggalPenulisan;
    }

    public function ambilReply() : ?IDComment {
        return $this->reply;
    }

    public function ambilStatus() : string {
        return $this->status;
    }
}

?>