<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\Soal;
use App\Core\Repository\InterfaceRepositorySoal;
use App\Core\Soal\Data\GagalBuatSoalException;
use App\Core\Soal\Data\TidakMemilikiHakException;
use App\Core\Soal\Interface\InterfacePengecekPembuatSoal;
use App\Core\Soal\Interface\InterfaceUbahSoal;
use InvalidArgumentException;

class UbahIsiSoal implements InterfaceUbahSoal {
    
    private const UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE = 255;
    private const UKURAN_MAKSIMAL_SOAL_DALAM_BYTE = 4000000;
    private const WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON = 10.0;
    private const WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON = 20.0;
    private const MEMORI_MAKSIMAL_DALAM_KB = 128000;
    
    private InterfacePengecekPembuatSoal $pengecekPembuatSoal;

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(
        InterfacePengecekPembuatSoal $pengecekPembuatSoal,
        InterfaceRepositorySoal $repositorySoal
    ) {
        if ($pengecekPembuatSoal == null) {
            throw new InvalidArgumentException("pengecekPembuatSoal bernilai null");
        }

        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal bernilai null");
        }

        $this->pengecekPembuatSoal = $pengecekPembuatSoal;
        $this->repositorySoal = $repositorySoal;
    }

    public function ubahSoal(IDUser $idUser, Soal $soalBaru): void
    {
        if (! $this->pengecekPembuatSoal->cekApakahUserYangMembuatSoal($idUser, $soalBaru->ambilIDSoal())) {
            throw new TidakMemilikiHakException("Tidak memiliki hak untuk emngubah soal");
        }

        if (strlen($soalBaru->ambilJudul()) > $this::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE) {
            throw new GagalBuatSoalException("Ukuran judul melebihi ".self::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE." byte");
        }

        if (strlen($soalBaru->ambilSoal()) > $this::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE) {
            throw new GagalBuatSoalException("Ukuran soal melebihi ".self::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE." byte");
        }

        if ($soalBaru->ambilBatasanWaktuPerTestcase() <= 0 || $soalBaru->ambilBatasanWaktuPerTestcase() > self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON) {
            throw new GagalBuatSoalException("Waktu per testcase harus diatas 0 sekon sampai maksimal ".self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON." sekon");
        }

        if ($soalBaru->ambilBatasanWaktuTotal() <= 0 || $soalBaru->ambilBatasanWaktuTotal() > self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON) {
            throw new GagalBuatSoalException("Waktu total semua testcase harus diatas 0 sekon sampai maksimal ".self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON." sekon");
        }

        if ($soalBaru->ambilBatasanMemoriDalamKB() <= 0 || $soalBaru->ambilBatasanMemoriDalamKB() > self::MEMORI_MAKSIMAL_DALAM_KB) {
            throw new GagalBuatSoalException("Batasan memori harus diatas 0 KB sampai maksimal ".self::MEMORI_MAKSIMAL_DALAM_KB." KB");
        }

        if ($this->repositorySoal->cekApakahJudulSudahDipakai($soalBaru->ambilJudul())) {
            throw new GagalBuatSoalException("Judul soal telah dipakai");
        }
        
        $this->repositorySoal->ubahSoal($soalBaru);
    }
}

?>