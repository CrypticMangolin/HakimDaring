<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\InterfaceRepositorySoal;
use App\Core\Soal\Data\GagalBuatSoalException;
use App\Core\Soal\Interface\InterfaceBuatSoal;
use Exception;
use Illuminate\Support\Facades\Auth;
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

        if ($this->repositorySoal->cekApakahJudulSudahDipakai($judul)) {
            throw new GagalBuatSoalException("Judul soal telah dipakai");
        }

        return $this->repositorySoal->buatSoal(new IDUser(Auth::id()), $judul, $soal);
    }
}

?>