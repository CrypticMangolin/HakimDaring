<?php 

declare(strict_types = 1);

namespace App\Application\Command\Soal\EditSoal;

use App\Application\Command\Soal\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\PenjelasanSoal;
use App\Core\Repository\Soal\Entitas\StatusSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\Entitas\IDTestcase;
use App\Core\Repository\Testcase\Entitas\JawabanTestcase;
use App\Core\Repository\Testcase\Entitas\PublisitasTestcase;
use App\Core\Repository\Testcase\Entitas\SoalTestcase;
use App\Core\Repository\Testcase\Entitas\Testcase;
use App\Core\Repository\Testcase\Entitas\UrutanTestcase;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use App\Core\Services\Soal\PengecekJumlahTestcase;
use App\Core\Services\Soal\PengecekTestcaseBaruBerbeda;
use App\Core\Services\Soal\PengecekTestcaseDuplikat;
use Illuminate\Support\Facades\Auth;

class CommandEditSoal {

    public function __construct(
        private PengecekJumlahTestcase $pengecekJumlahTestcase,
        private PengecekTestcaseDuplikat $pengecekTestcaseDuplikat,
        private PengecekTestcaseBaruBerbeda $pengecekTestcaseBaruBerbeda,
        private InterfaceRepositorySoal $repositorySoal,
        private InterfaceRepositoryTestcase $repositoryTestcase,
    )
    {
        
    }

    public function execute(RequestEditSoal $request) : void {
        
        $idPemintaRequest = new IDUser(Auth::id());
        $idSoal = new IDSoal($request->idSoal);    
        $penjelasanSoal = PenjelasanSoal::buatPenjelasanSoal($request->judulSoal, $request->soal);
        $batasanSoal = BatasanSoal::buatBatasanSoal($request->batasanSoalWaktuPerTestcase, $request->batasanSoalTotalWaktu, $request->batasanSoalMemori);

        $soalYangDiganti = $this->repositorySoal->byId($idSoal);
        $soalDenganJudulYangSama = $this->repositorySoal->byJudul($penjelasanSoal);

        if ($soalYangDiganti === null) {
            throw new ApplicationException("soal tidak ada");
        }

        if ($idPemintaRequest->ambilID() != $soalYangDiganti->ambilIDPembuat()->ambilID()) {
            throw new ApplicationException("tidak memiliki hak");
        }

        if ($soalDenganJudulYangSama !== null && $soalDenganJudulYangSama->ambilStatusSoal()->ambilStatus() != StatusSoal::DELETED) {
            throw new ApplicationException("judul telah dipakai");
        }

        $soalYangDiganti->gantiPenjelasanSoal($penjelasanSoal);
        $daftarTestcaseLama = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($soalYangDiganti->ambilIDSoal(), $soalYangDiganti->ambilVersiSoal());

        
        $daftarTestcaseBaru = [];
        for($i = 0; $i < count($request->daftarTestcase) && $i < PengecekJumlahTestcase::JUMLAH_MAKSIMAL_TESTCASE + 1; $i++) {
            $testcase = $request->daftarTestcase[$i];
            array_push($daftarTestcaseBaru, new Testcase(
                new IDTestcase(null),
                $soalYangDiganti->ambilIDSoal(),
                new SoalTestcase($testcase["soal"]),
                new JawabanTestcase($testcase["jawaban"]),
                new UrutanTestcase($testcase[$i]),
                new PublisitasTestcase($testcase["publik"] ? PublisitasTestcase::PUBLIK : PublisitasTestcase::PRIVATE)
            ));
        }
        
        if (! $this->pengecekJumlahTestcase->cekTestcaseTidakMelebihiBatas($daftarTestcaseBaru)) {
            throw new ApplicationException("jumlah testcase melebihi batas ".PengecekJumlahTestcase::JUMLAH_MAKSIMAL_TESTCASE);
        }
        if (! $this->pengecekJumlahTestcase->cekTestcasePublikTidakMelebihiBatas($daftarTestcaseBaru)) {
            throw new ApplicationException("jumlah testcase publik melebihi batas ".PengecekJumlahTestcase::JUMLAH_MAKSIMAL_TESTCASE_PUBLIK);
        }
        if (! $this->pengecekTestcaseDuplikat->cekApakahTestcaseDuplikat($daftarTestcaseBaru)) {
            throw new ApplicationException("terdapat testcase duplikat");
        }

        $versiSoalYangDiganti = $soalYangDiganti->ambilVersiSoal();
        if ($soalYangDiganti->ambilBatasanSoal() != $batasanSoal || $this->pengecekTestcaseBaruBerbeda->cekApakahBerbeda($daftarTestcaseBaru, $daftarTestcaseLama)) {
            $soalYangDiganti->gantiBatasanSoal($batasanSoal);
            $versiSoalYangDiganti->tambahVersiSoal();
            $this->repositorySoal->update($soalYangDiganti);
            $this->repositoryTestcase->setTestcaseUntukSoal($soalYangDiganti->ambilIDSoal(), $versiSoalYangDiganti, $daftarTestcaseBaru);
        }

    }
}

?>