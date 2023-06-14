<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Soal\Entitas;

use App\Core\Repository\Exception\MelebihiUkuranMaksimalException;
use InvalidArgumentException;

class PenjelasanSoal {
    
    private const UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE = 255;
    private const UKURAN_MAKSIMAL_SOAL_DALAM_BYTE = 4000000;

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

    public static function buatPenjelasanSoal(string $judul, string $soal) : PenjelasanSoal {
        if (strlen($judul) > self::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE) {
            throw new MelebihiUkuranMaksimalException("Ukuran judul melebihi ".self::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE." byte");
        }

        if (strlen($soal) > self::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE) {
            throw new MelebihiUkuranMaksimalException("Ukuran soal melebihi ".self::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE." byte");
        }

        return new PenjelasanSoal($judul, $soal);
    }
}

?>