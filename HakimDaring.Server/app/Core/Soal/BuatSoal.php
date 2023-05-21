<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\DataSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Soal\Exception\GagalBuatSoalException;
use App\Core\Soal\Interface\InterfaceBuatSoal;
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
    
    public function buatSoal(DataSoal $dataSoal) : IDSoal
    {
        if (strlen($dataSoal->ambilJudul()) > $this::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE) {
            throw new GagalBuatSoalException("Ukuran judul melebihi ".self::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE." byte");
        }

        if (strlen($dataSoal->ambilSoal()) > $this::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE) {
            throw new GagalBuatSoalException("Ukuran soal melebihi ".self::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE." byte");
        }

        if ($this->repositorySoal->cekApakahJudulSudahDipakai($dataSoal->ambilJudul())) {
            throw new GagalBuatSoalException("Judul soal telah dipakai");
        }

        return $this->repositorySoal->buatSoal(new IDUser(Auth::id()), $dataSoal);
    }
}

?>