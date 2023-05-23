<?php 

declare(strict_types = 1);

namespace App\Core\Comment;

use App\Core\Comment\Exception\GagalMembuatKomentarException;
use App\Core\Comment\Interface\InterfaceTambahComment;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\CommentBaru;
use App\Core\Repository\Comment\Entitas\DataComment;
use App\Core\Repository\Comment\Entitas\IDComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use DateTime;

class TambahComment implements InterfaceTambahComment {
    
    private const UKURAN_MAKSIMAL_COMMENT = 5000000;

    public function __construct(
        private InterfaceRepositoryComment $repositoryComment
    ) {}

    public function tambahComment(
        IDRuanganComment $idRuanganComment,
        IDUser $idUser,
        string $pesan,
        ?IDComment $reply
    ) : void {

        // check apakah user boleh menulis soal

        if (strlen($pesan) > $this::UKURAN_MAKSIMAL_COMMENT) {
            throw new GagalMembuatKomentarException("Ukuran comment melebihi ".self::UKURAN_MAKSIMAL_COMMENT." byte");
        }

        $this->repositoryComment->tambahComment(
            new CommentBaru(
                $idRuanganComment, 
                $idUser, 
                $pesan, 
                new DateTime("now"), 
                $reply, 
                "publik"
            )
        );        
    }
}

?>