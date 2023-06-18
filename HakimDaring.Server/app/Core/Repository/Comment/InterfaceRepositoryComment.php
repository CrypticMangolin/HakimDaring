<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\Comment;
use App\Core\Repository\Comment\Entitas\CommentBaru;
use App\Core\Repository\Comment\Entitas\DataComment;
use App\Core\Repository\Comment\Entitas\IDComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Comment\Entitas\RuanganComment;

interface InterfaceRepositoryComment {

    public function ruanganCommentById(IDRuanganComment $idRuanganComment) : ?RuanganComment;

    public function ruanganCommentSave(RuanganComment $ruanganComment) : void;



    public function commentById(IDComment $idComment) : ?Comment;
    /**
     * @return Comment[]
     */
    public function commentByIdRuangan(IDRuanganComment $idRuanganComment) : array;
    
    public function commentSave(Comment $comment) : void;

    public function commentUpdate(Comment $comment) : void;
}

?>