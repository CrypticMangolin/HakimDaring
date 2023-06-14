<?php 

declare(strict_types = 1);

namespace App\Application\Query\Comment;

class CommentDTO {

    public function __construct(
        public string $idComment,
        public string $idPenulis,
        public string $namaPenulis,
        public string $isiPesan,
        public string $tanggalPenulisan,
        public ?string $reply,
        public string $status
    )
    {
    
    }
}

?>