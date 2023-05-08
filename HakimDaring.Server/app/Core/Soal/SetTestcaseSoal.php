<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\IDSoal;
use App\Core\Repository\InterfaceRepositoryTestcase;
use App\Core\Soal\Data\TestcaseDuplikatException;
use InvalidArgumentException;

class SetTestcaseSoal implements InterfaceSetTestcaseSoal {

    private InterfacePengecekTestcaseDuplikat $pengecekTestcaseDuplikat;

    private InterfacePengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda;

    private InterfaceRepositoryTestcase $repositoryTestcase;

    public function __construct(
        PengecekTestcaseDuplikat $pengecekTestcaseDuplikat, 
        InterfaceRepositoryTestcase $repositoryTestcase,
        InterfacePengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda
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

        $this->pengecekTestcaseDuplikat = $pengecekTestcaseDuplikat;
        $this->repositoryTestcase = $repositoryTestcase;
        $this->pengecekTestcaseBaruBerbeda = $pengecekTestcaseBaruBerbeda;
    }

    public function setTestcase(IDSoal $idSoal, array $testcaseBesertaJawaban) : bool
    {
        if ($this->pengecekTestcaseDuplikat->cekApakahTestcaseDuplikat($testcaseBesertaJawaban)) {
            $kumpulanTestcaseLama = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($idSoal);
            if ($this->pengecekTestcaseBaruBerbeda->cekApakahBerbeda($testcaseBesertaJawaban, $kumpulanTestcaseLama)) {
                
                return true;
            }
            else {
                return false;
            }
        }
        else {
            throw new TestcaseDuplikatException();
        }
        return false;
    }

}

?>