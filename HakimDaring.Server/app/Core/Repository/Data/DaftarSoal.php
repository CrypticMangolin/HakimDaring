<?php

declare(strict_types = 1);

namespace App\Core\Repository\Data;

class DaftarSoal {

    private IDSoal $idSoal;
    private string $judul;
    private string $statusPengerjaan;
    private float $keberhasilan;

    public function __construct(IDSoal $idSoal, string $judul, string $statusPengerjaan, $keberhasilan)
    {
        $this->idSoal = $idSoal;
        $this->judul = $judul;
        $this->statusPengerjaan = $statusPengerjaan;
        $this->keberhasilan = $keberhasilan;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    public function ambilJudul() : string {
        return $this->judul;
    }

    public function ambilStatusPengerjaan() : string {
        return $this->statusPengerjaan;
    }

    public function ambilKeberhasilan() : float {
        return $this->keberhasilan;
    }
}

?>