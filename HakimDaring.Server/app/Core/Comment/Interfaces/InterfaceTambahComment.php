<?php

namespace App\Core\Comment\Interfaces;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\IDComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use DateTime;

interface InterfaceTambahComment {

    public function tambahComment(
        IDRuanganComment $idRuanganComment,
        IDUser $idUser,
        string $pesan,
        ?IDComment $reply
    ) : void;
}

?>