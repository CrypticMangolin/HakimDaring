<?php 

declare(strict_types = 1);

namespace App\Application\Query\Comment;

interface InterfaceQueryComment {

    /**
     * @return CommentDTO[]
     */
    public function byIDRuanganComment(string $idRuanganComment) : array;
    
}

?>