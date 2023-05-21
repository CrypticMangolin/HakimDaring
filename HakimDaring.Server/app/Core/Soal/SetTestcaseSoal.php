<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use App\Core\Soal\Exception\TestcaseDuplikatException;
use App\Core\Soal\Exception\TidakMemilikiHakException;
use App\Core\Soal\Interface\InterfacePengecekBatasanBerbeda;
use App\Core\Soal\Interface\InterfacePengecekPembuatSoal;
use App\Core\Soal\Interface\InterfacePengecekTestcaseBaruBerbeda;
use App\Core\Soal\Interface\InterfacePengecekTestcaseDuplikat;
use App\Core\Soal\Interface\InterfaceSetTestcaseSoal;
use InvalidArgumentException;

class SetTestcaseSoal implements InterfaceSetTestcaseSoal {

    private const WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON = 10.0;
    private const WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON = 20.0;
    private const MEMORI_MAKSIMAL_DALAM_KB = 128000;

    private InterfacePengecekPembuatSoal $pengecekPembuatSoal;
    private InterfacePengecekTestcaseDuplikat $pengecekTestcaseDuplikat;
    private InterfacePengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda;
    private InterfacePengecekBatasanBerbeda $pengecekbatasanBaruBerbeda;
    private InterfaceRepositoryTestcase $repositoryTestcase;
    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(
        InterfacePengecekTestcaseDuplikat $pengecekTestcaseDuplikat, 
        InterfaceRepositoryTestcase $repositoryTestcase,
        InterfacePengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda,
        InterfacePengecekBatasanBerbeda $pengecekbatasanBaruBerbeda,
        InterfacePengecekPembuatSoal $pengecekPembuatSoal,
        InterfaceRepositorySoal $repositorySoal
    ) {
        if ($pengecekTestcaseDuplikat == null) {
            throw new InvalidArgumentException("pengecekTestcaseDuplikat bernilai null");
        }
        
        if ($repositoryTestcase == null) {
            throw new InvalidArgumentException("repositoryTestcase bernilai null");
        }
        
        if ($pengecekTestcaseBaruBerbeda == null) {
            throw new InvalidArgumentException("pengecekTestcaseBaruBerbeda bernilai null");
        }
        
        if ($pengecekbatasanBaruBerbeda == null) {
            throw new InvalidArgumentException("pengecekbatasanBaruBerbeda bernilai null");
        }

        if ($pengecekPembuatSoal == null) {
            throw new InvalidArgumentException("pengecekPembuatSoal bernilai null");
        }

        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal bernilai null");
        }

        $this->pengecekTestcaseDuplikat = $pengecekTestcaseDuplikat;
        $this->repositoryTestcase = $repositoryTestcase;
        $this->pengecekTestcaseBaruBerbeda = $pengecekTestcaseBaruBerbeda;
        $this->pengecekbatasanBaruBerbeda = $pengecekbatasanBaruBerbeda;
        $this->pengecekPembuatSoal = $pengecekPembuatSoal;
        $this->repositorySoal = $repositorySoal;
    }

    public function setTestcase(IDUser $idUser, IDSoal $idSoal, BatasanSoal $batasanBaru, array $testcaseBesertaJawaban) : void
    {
        if (!$this->pengecekPembuatSoal->cekApakahUserYangMembuatSoal($idUser, $idSoal)) {
            throw new TidakMemilikiHakException();
        }

        if (!$this->pengecekTestcaseDuplikat->cekApakahTestcaseDuplikat($testcaseBesertaJawaban)) {
            throw new TestcaseDuplikatException();
        }

        if ($batasanBaru->ambilBatasanWaktuPerTestcase() <= 0 || $batasanBaru->ambilBatasanWaktuPerTestcase() > self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON) {
            throw new InvalidArgumentException("Batasan waktu per testcase harus lebih dari 0 sekon dan kurang dari ".self::WAKTU_MAKSIMAL_PER_TESTCASE_DALAM_SEKON." sekon");
        }

        if ($batasanBaru->ambilBatasanWaktuTotal() <= 0 || $batasanBaru->ambilBatasanWaktuTotal() > self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON) {
            throw new InvalidArgumentException("Batasan waktu total testcase harus lebih dari 0 sekon dan kurang dari ".self::WAKTU_MAKSIMAL_SEMUA_TESTCASE_DALAM_SEKON." sekon");
        }
        
        if ($batasanBaru->ambilBatasanMemoriDalamKB() <= 0 || $batasanBaru->ambilBatasanMemoriDalamKB() > self::MEMORI_MAKSIMAL_DALAM_KB) {
            throw new InvalidArgumentException("Batasan waktu per testcase harus lebih dari 0 KB dan kurang dari ".self::MEMORI_MAKSIMAL_DALAM_KB." KB");
        }
        
        $versiSoalLama = $this->repositorySoal->ambilVersiSoal($idSoal);
        $kumpulanTestcaseLama = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($idSoal, $versiSoalLama);

        if ($this->pengecekTestcaseBaruBerbeda->cekApakahBerbeda($testcaseBesertaJawaban, $kumpulanTestcaseLama) ||
            $this->pengecekbatasanBaruBerbeda->cakApakahBatasanBerbeda($idSoal, $batasanBaru)
        ) {
            $this->repositorySoal->tambahVersiSoal($idSoal);
            $this->repositorySoal->setBatasanSoal($idSoal, $batasanBaru);
            $versiSoalBaru = $this->repositorySoal->ambilVersiSoal($idSoal);
            $this->repositoryTestcase->setTestcaseUntukSoal($idSoal, $versiSoalBaru, $testcaseBesertaJawaban);
        }
    }

}

?>