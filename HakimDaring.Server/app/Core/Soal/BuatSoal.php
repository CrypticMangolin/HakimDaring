<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Data\DataSoal;
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
    private const WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON = 10.0;
    private const WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON = 20.0;
    private const MEMORI_MAKSIMAL_DALAM_KB = 128000;

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

        if ($dataSoal->ambilBatasanWaktuPerTestcase() <= 0 || $dataSoal->ambilBatasanWaktuPerTestcase() > self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON) {
            throw new GagalBuatSoalException("Waktu per testcase harus diatas 0 sekon sampai maksimal ".self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON." sekon");
        }

        if ($dataSoal->ambilBatasanWaktuTotal() <= 0 || $dataSoal->ambilBatasanWaktuTotal() > self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON) {
            throw new GagalBuatSoalException("Waktu total semua testcase harus diatas 0 sekon sampai maksimal ".self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON." sekon");
        }

        if ($dataSoal->ambilBatasanMemoriDalamKB() <= 0 || $dataSoal->ambilBatasanMemoriDalamKB() > self::MEMORI_MAKSIMAL_DALAM_KB) {
            throw new GagalBuatSoalException("Batasan memori harus diatas 0 KB sampai maksimal ".self::MEMORI_MAKSIMAL_DALAM_KB." KB");
        }

        if ($this->repositorySoal->cekApakahJudulSudahDipakai($dataSoal->ambilJudul())) {
            throw new GagalBuatSoalException("Judul soal telah dipakai");
        }

        return $this->repositorySoal->buatSoal(new IDUser(Auth::id()), $dataSoal);
    }
}

?>