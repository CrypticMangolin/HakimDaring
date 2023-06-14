<?php 

declare(strict_types = 1);

namespace App\Application\Command\Comment\TambahComment;

class RequestTambahComment {

    public function __construct(
        public string $idRuangan,
        public string $isiComment,
        public ?string $reply
    )
    {
        
    }
}

?>