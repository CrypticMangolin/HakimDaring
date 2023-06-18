<?php 

declare(strict_types = 1);

namespace App\Application\Command\Comment;

class RequestHapusComment {

    public function __construct(
        public string $idRuangan, 
        public string $idComment
    )
    {
        
    }
}

?>