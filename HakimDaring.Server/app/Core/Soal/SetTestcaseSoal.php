<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\InterfaceRepositorySoal;
use App\Core\Repository\InterfaceRepositoryTestcase;
use App\Core\Soal\Data\TestcaseDuplikatException;
use App\Core\Soal\Data\TidakMemilikiHakException;
use App\Core\Soal\Interface\InterfacePengecekPembuatSoal;
use App\Core\Soal\Interface\InterfacePengecekTestcaseBaruBerbeda;
use App\Core\Soal\Interface\InterfacePengecekTestcaseDuplikat;
use App\Core\Soal\Interface\InterfaceSetTestcaseSoal;
use InvalidArgumentException;

class SetTestcaseSoal implements InterfaceSetTestcaseSoal {

    private InterfacePengecekPembuatSoal $pengecekPembuatSoal;

    private InterfacePengecekTestcaseDuplikat $pengecekTestcaseDuplikat;

    private InterfacePengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda;

    private InterfaceRepositoryTestcase $repositoryTestcase;

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(
        PengecekTestcaseDuplikat $pengecekTestcaseDuplikat, 
        InterfaceRepositoryTestcase $repositoryTestcase,
        InterfacePengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda,
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

        if ($pengecekPembuatSoal == null) {
            throw new InvalidArgumentException("pengecekPembuatSoal bernilai null");
        }

        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal bernilai null");
        }

        $this->pengecekTestcaseDuplikat = $pengecekTestcaseDuplikat;
        $this->repositoryTestcase = $repositoryTestcase;
        $this->pengecekTestcaseBaruBerbeda = $pengecekTestcaseBaruBerbeda;
        $this->pengecekPembuatSoal = $pengecekPembuatSoal;
        $this->repositorySoal = $repositorySoal;
    }

    public function setTestcase(IDUser $idUser, IDSoal $idSoal, array $testcaseBesertaJawaban) : void
    {
        if (!$this->pengecekPembuatSoal->cekApakahUserYangMembuatSoal($idUser, $idSoal)) {
            throw new TidakMemilikiHakException();
        }

        if (!$this->pengecekTestcaseDuplikat->cekApakahTestcaseDuplikat($testcaseBesertaJawaban)) {
            throw new TestcaseDuplikatException();
        }
        
        $kumpulanTestcaseLama = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($idSoal);
        if ($this->pengecekTestcaseBaruBerbeda->cekApakahBerbeda($testcaseBesertaJawaban, $kumpulanTestcaseLama)) {
            $this->repositoryTestcase->hapusSemuaTestcaseSoal($idSoal);
            $this->repositoryTestcase->setTestcaseUntukSoal($idSoal, $testcaseBesertaJawaban);
            $this->repositorySoal->tambahVersiSoal($idSoal);
        }
    }

}

?>