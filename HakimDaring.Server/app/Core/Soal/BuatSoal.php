<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\IDSoal;
use App\Core\Repository\InterfaceRepositorySoal;
use App\Core\Soal\Data\GagalBuatSoalException;
use Exception;
use InvalidArgumentException;

class BuatSoal implements InterfaceBuatSoal {
    
    private const UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE = 255;
    private const UKURAN_MAKSIMAL_SOAL_DALAM_BYTE = 4000000;

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(InterfaceRepositorySoal $repositorySoal)
    {
        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal Null");
        }
        $this->repositorySoal = $repositorySoal;
    }
    
    public function buatSoal(string $judul, string $soal) : IDSoal
    {
        if (strlen($judul) > $this::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE) {
            throw new GagalBuatSoalException("Ukuran judul melebihi ".self::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE." byte");
        }

        if (strlen($soal) > $this::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE) {
            throw new GagalBuatSoalException("Ukuran soal melebihi ".self::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE." byte");
        }

        return $this->repositorySoal->buatSoal($judul, $soal);
    }
}

?>