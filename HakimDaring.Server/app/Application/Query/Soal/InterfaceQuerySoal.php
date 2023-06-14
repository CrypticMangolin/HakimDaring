<?php 

declare(strict_types = 1);

namespace App\Application\Query\Soal;

interface InterfaceQuerySoal {

    public function byID(string $idSoal) : ?SoalDTO;
    
}

?>