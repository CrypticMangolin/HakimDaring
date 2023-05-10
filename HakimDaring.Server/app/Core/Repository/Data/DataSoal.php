<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Data;

use InvalidArgumentException;

class DataSoal {

    private string $judul;
    private string $soal;

    public function __construct(string $judul, string $soal)
    {
        if ($judul == null) {
            throw new InvalidArgumentException("judul bernilai null");
        }

        if ($soal == null) {
            throw new InvalidArgumentException("soal bernilai null");
        }

        $this->judul = $judul;
        $this->soal = $soal;
    }

    public function ambilJudul() : string {
        return $this->judul;
    }

    public function ambilSoal() : string {
        return $this->soal;
    }
}

?>