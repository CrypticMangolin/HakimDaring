<?php

declare(strict_types = 1);

namespace App\Core\Repository\DaftarSoal\Entitas;

use App\Core\Repository\Soal\Entitas\IDSoal;

class HasilPencarianSoal {

    private IDSoal $idSoal;
    private string $judul;
    private int $jumlahSubmit;
    private int $berhasilSubmit;
    private float $persentaseBerhasil;

    public function __construct(IDSoal $idSoal, string $judul, int $jumlahSubmit, int $berhasilSubmit, float $persentaseBerhasil)
    {
        $this->idSoal = $idSoal;
        $this->judul = $judul;
        $this->jumlahSubmit = $jumlahSubmit;
        $this->berhasilSubmit = $berhasilSubmit;
        $this->persentaseBerhasil = $persentaseBerhasil;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    public function ambilJudul() : string {
        return $this->judul;
    }

    public function ambilJumlahSubmit() : int {
        return $this->jumlahSubmit;
    }

    public function ambilBerhasilSubmit() : int {
        return $this->berhasilSubmit;
    }

    public function ambilPersentaseBerhasil() : float {
        return $this->persentaseBerhasil;
    }
}

?>