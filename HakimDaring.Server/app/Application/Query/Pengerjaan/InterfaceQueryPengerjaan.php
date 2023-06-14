<?php 

declare(strict_types = 1);

namespace App\Application\Query\Pengerjaan;

interface InterfaceQueryPengerjaan {
    
    /**
     * @return PengerjaanDTO[]
     */
    public function byPengsubmitDanSoal(string $idPengsubmit, string $idSoal) : array;

    public function byId(string $idPengerjaan) : ?PengerjaanDTO;

    /**
     * @return HasilTestcaseDTO[]
     */
    public function ambilHasilTestcase(string $idPengerjaan) : array;
}

?>