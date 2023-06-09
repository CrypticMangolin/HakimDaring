<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\DataSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\Entitas\Testcase;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use App\Core\Soal\Exception\GagalBuatSoalException;
use App\Core\Soal\Exception\JumlahTestcaseMelebihiBatas;
use App\Core\Soal\Exception\TestcaseDuplikatException;
use App\Core\Soal\Interfaces\InterfaceBuatSoal;
use App\Core\Soal\Interfaces\InterfacePengecekBatasan;
use App\Core\Soal\Interfaces\InterfacePengecekJumlahTestcase;
use App\Core\Soal\Interfaces\InterfacePengecekTestcaseDuplikat;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class BuatSoal implements InterfaceBuatSoal {
    
    private const UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE = 255;
    private const UKURAN_MAKSIMAL_SOAL_DALAM_BYTE = 4000000;

    private InterfaceRepositorySoal $repositorySoal;
    private InterfaceRepositoryComment $repositoryComment;
    private InterfaceRepositoryTestcase $repositoryTestcase;
    private InterfacePengecekBatasan $pengecekBatasan;
    private InterfacePengecekTestcaseDuplikat $pengecekTestcaseDuplikat;
    private InterfacePengecekJumlahTestcase $pengecekJumlahTestcase;

    public function __construct(
        InterfaceRepositorySoal $repositorySoal, 
        InterfaceRepositoryComment $repositoryComment,
        InterfaceRepositoryTestcase $repositoryTestcase,  
        InterfacePengecekBatasan $pengecekBatasan,
        InterfacePengecekTestcaseDuplikat $pengecekTestcaseDuplikat,
        InterfacePengecekJumlahTestcase $pengecekJumlahTestcase
    )
    {
        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal Null");
        }

        if ($repositoryComment == null) {
            throw new InvalidArgumentException("repositoryComment Null");
        }

        if ($pengecekTestcaseDuplikat == null) {
            throw new InvalidArgumentException("pengecekTestcaseDuplikat Null");
        }

        if ($pengecekJumlahTestcase == null) {
            throw new InvalidArgumentException("pengecekJumlahTestcase Null");
        }

        if ($pengecekBatasan == null) {
            throw new InvalidArgumentException("pengecekBatasan Null");
        }

        if ($repositoryTestcase == null) {
            throw new InvalidArgumentException("repositoryTestcase Null");
        }

        $this->repositorySoal = $repositorySoal;
        $this->repositoryComment = $repositoryComment;
        $this->repositoryTestcase = $repositoryTestcase;
        $this->pengecekTestcaseDuplikat = $pengecekTestcaseDuplikat;
        $this->pengecekJumlahTestcase = $pengecekJumlahTestcase;
        $this->pengecekBatasan = $pengecekBatasan;
    }
    
    public function buatSoal(IDuser $idUser, DataSoal $dataSoal, BatasanSoal $batasanSoal, array $daftarTestcase) : IDSoal
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

        if (!$this->pengecekTestcaseDuplikat->cekApakahTestcaseDuplikat($daftarTestcase)) {
            throw new TestcaseDuplikatException();
        }

        if (! $this->pengecekJumlahTestcase->cekTestcaseTidakMelebihiBatas($daftarTestcase)) {
            throw new JumlahTestcaseMelebihiBatas("Jumlah maksimal testcase adalah".$this->pengecekJumlahTestcase::JUMLAH_MAKSIMAL_TESTCASE);
        }

        if (! $this->pengecekJumlahTestcase->cekTestcasePublikTidakMelebihiBatas($daftarTestcase)) {
            throw new JumlahTestcaseMelebihiBatas("Jumlah testcase publik adalah".$this->pengecekJumlahTestcase::JUMLAH_MAKSIMAL_TESTCASE_PUBLIK);
        }

        $this->pengecekBatasan->cekApakahBatasanMemenuhiSyarat($batasanSoal);

        $idRuanganComment = $this->repositoryComment->buatRuanganComment($idUser);
        $idSoal = $this->repositorySoal->buatSoal($idUser, $dataSoal, $batasanSoal, $idRuanganComment);
        $versiSoal = $this->repositorySoal->ambilVersiSoal($idSoal);
        $this->repositoryTestcase->setTestcaseUntukSoal($idSoal, $versiSoal, $daftarTestcase);
        
        return $idSoal;
    }
}

?>