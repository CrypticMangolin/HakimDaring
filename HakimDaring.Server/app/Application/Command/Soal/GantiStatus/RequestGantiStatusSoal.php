<?php 

declare(strict_types = 1);

namespace App\Application\Command\Soal\GantiStatus;

class RequestGantiStatusSoal {

    public function __construct(
        public string $idSoal,
        public string $statusSoal
    )
    {

    }
}

?>