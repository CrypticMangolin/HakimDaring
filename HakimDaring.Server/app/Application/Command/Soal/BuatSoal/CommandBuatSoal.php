<?php 

declare(strict_types = 1);

namespace App\Application\Command\Soal\BuatSoal;

use App\Application\Command\Soal\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Comment\Entitas\RuanganComment;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\HasilSubmitSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\PenjelasanSoal;
use App\Core\Repository\Soal\Entitas\Soal;
use App\Core\Repository\Soal\Entitas\StatusSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\Entitas\IDTestcase;
use App\Core\Repository\Testcase\Entitas\JawabanTestcase;
use App\Core\Repository\Testcase\Entitas\PublisitasTestcase;
use App\Core\Repository\Testcase\Entitas\SoalTestcase;
use App\Core\Repository\Testcase\Entitas\Testcase;
use App\Core\Repository\Testcase\Entitas\UrutanTestcase;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use App\Core\Services\Soal\PengecekBatasan;
use App\Core\Services\Soal\PengecekJumlahTestcase;
use App\Core\Services\Soal\PengecekTestcaseDuplikat;
use Illuminate\Support\Facades\Auth;

class CommandBuatSoal {
    
    public function __construct(
        private PengecekJumlahTestcase $pengecekJumlahTestcase,
        private PengecekTestcaseDuplikat $pengecekTestcaseDuplikat,
        private InterfaceRepositorySoal $repositorySoal,
        private InterfaceRepositoryComment $repositoryComment,
        private InterfaceRepositoryTestcase $repositoryTestcase
    )
    {
        
    }

    public function execute(RequestBuatSoal $request) : IDSoal
    {
        $idUser = new IDUser(Auth::id());
        $idSoal = new IDSoal(null);
        $penjelasanSoal = PenjelasanSoal::buatPenjelasanSoal($request->judulSoal, $request->soal);
        $batasanSoal = BatasanSoal::buatBatasanSoal($request->batasanSoalWaktuPerTestcase, $request->batasanSoalTotalWaktu, $request->batasanSoalMemori);
        $versiSoal = new VersiSoal(1, new HasilSubmitSoal(0, 0));
        $statusSoal = new StatusSoal(StatusSoal::PUBLIK, 0);
        $ruanganComment = new RuanganComment(new IDRuanganComment(null), $idUser);
        $soalBaru = new Soal($idSoal, $idUser, $penjelasanSoal, $batasanSoal, $versiSoal, $statusSoal, $ruanganComment->ambilIDRuangan());

        $soalLain = $this->repositorySoal->byJudul($soalBaru->ambilPenjelasanSoal());
        if ($soalLain !== null) {
            throw new ApplicationException("judul telah dipakai");
        }

        $daftarTestcase = [];
        for($i = 0; $i < count($request->daftarTestcase) && $i < PengecekJumlahTestcase::JUMLAH_MAKSIMAL_TESTCASE + 1; $i++) {
            $testcase = $request->daftarTestcase[$i];
            array_push($daftarTestcase, new Testcase(
                new IDTestcase(null),
                $soalBaru->ambilIDSoal(),
                new SoalTestcase($testcase["soal"]),
                new JawabanTestcase($testcase["jawaban"]),
                new UrutanTestcase($testcase[$i]),
                new PublisitasTestcase($testcase["publik"] ? PublisitasTestcase::PUBLIK : PublisitasTestcase::PRIVATE)
            ));
        }

        if (! $this->pengecekJumlahTestcase->cekTestcaseTidakMelebihiBatas($daftarTestcase)) {
            throw new ApplicationException("Testcase maksimal berjumlah".PengecekJumlahTestcase::JUMLAH_MAKSIMAL_TESTCASE);
        }

        if (! $this->pengecekJumlahTestcase->cekTestcasePublikTidakMelebihiBatas($daftarTestcase)) {
            throw new ApplicationException("Testcase publik maksimal berjumlah".PengecekJumlahTestcase::JUMLAH_MAKSIMAL_TESTCASE_PUBLIK);
        }

        $this->repositoryComment->ruanganCommentSave($ruanganComment);
        $this->repositorySoal->save($soalBaru);
        $this->repositoryTestcase->setTestcaseUntukSoal($idSoal, $versiSoal, $daftarTestcase);

        return $idSoal;
    }
}

?>