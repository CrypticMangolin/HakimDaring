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
use App\Core\Soal\Interfaces\InterfacePengecekBatasan;
use App\Core\Soal\Interfaces\InterfacePengecekPembuatSoal;
use App\Core\Soal\Interfaces\InterfacePengecekTestcaseBaruBerbeda;
use App\Core\Soal\Interfaces\InterfacePengecekTestcaseDuplikat;
use App\Core\Soal\Interfaces\InterfaceSetTestcaseSoal;
use InvalidArgumentException;

class SetTestcaseSoal implements InterfaceSetTestcaseSoal {

    private InterfacePengecekPembuatSoal $pengecekPembuatSoal;
    private InterfacePengecekTestcaseDuplikat $pengecekTestcaseDuplikat;
    private InterfacePengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda;
    private InterfacePengecekBatasan $pengecekBatasan;
    private InterfaceRepositoryTestcase $repositoryTestcase;
    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(
        InterfacePengecekTestcaseDuplikat $pengecekTestcaseDuplikat, 
        InterfaceRepositoryTestcase $repositoryTestcase,
        InterfacePengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda,
        InterfacePengecekBatasan $pengecekBatasan,
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
        
        if ($pengecekBatasan == null) {
            throw new InvalidArgumentException("pengecekbatasanBaru bernilai null");
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
        $this->pengecekBatasan = $pengecekBatasan;
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

        $this->pengecekBatasan->cekApakahBatasanMemenuhiSyarat($batasanBaru);
        
        $versiSoalLama = $this->repositorySoal->ambilVersiSoal($idSoal);
        $kumpulanTestcaseDataSubmitLama = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($idSoal, $versiSoalLama);
        $kumpulanTestcaseLama = [];
        foreach ($kumpulanTestcaseDataSubmitLama as $testcaseDataSubmit) {
            array_push($kumpulanTestcaseLama, $testcaseDataSubmit->ambilDataTestcase()->ambilTestcase());
        }

        $kumpulanTestcaseBaru = [];
        foreach ($testcaseBesertaJawaban as $testcaseDataSubmit) {
            array_push($kumpulanTestcaseBaru, $testcaseDataSubmit->ambilTestcase());
        }

        if ($this->pengecekTestcaseBaruBerbeda->cekApakahBerbeda($kumpulanTestcaseBaru, $kumpulanTestcaseLama) ||
            $this->pengecekBatasan->cekApakahBatasanBerbeda($idSoal, $batasanBaru)
        ) {
            $this->repositorySoal->tambahVersiSoal($idSoal);
            $this->repositorySoal->setBatasanSoal($idSoal, $batasanBaru);
            $versiSoalBaru = $this->repositorySoal->ambilVersiSoal($idSoal);
            $this->repositoryTestcase->setTestcaseUntukSoal($idSoal, $versiSoalBaru, $testcaseBesertaJawaban);
        }
    }

}

?>