<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal;

use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\PenjelasanSoal;
use App\Core\Repository\Soal\Entitas\Soal;

interface InterfaceRepositorySoal {

    public function byId(IDSoal $idSoal) : ?Soal;
    public function byJudul(PenjelasanSoal $penjelasanSoal) : ?Soal;
    public function save(Soal $soal) : void;
    public function update(Soal $soal) : void;
}

?>