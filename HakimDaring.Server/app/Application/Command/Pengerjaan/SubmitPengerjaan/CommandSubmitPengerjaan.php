<?php 

declare(strict_types = 1);

namespace App\Application\Command\Pengerjaan\SubmitPengerjaan;

use App\Application\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Pengerjaan\Entitas\HasilPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\HasilPengerjaanTestcase;
use App\Core\Repository\Pengerjaan\Entitas\HasilSubmission;
use App\Core\Repository\Pengerjaan\Entitas\IDPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\Pengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\PengerjaanTestcase;
use App\Core\Repository\Pengerjaan\Entitas\SourceCodePengerjaan;
use App\Core\Repository\Pengerjaan\InterfaceRepositoryPengerjaan;
use App\Core\Repository\Pengerjaan\InterfaceRepositoryPengerjaanTestcase;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\StatusSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use App\Core\Services\Pengerjaan\InterfaceRequestServer;
use DateTime;
use Illuminate\Support\Facades\Auth;

class CommandSubmitPengerjaan {

    public function __construct(
        public InterfaceRepositorySoal $repositorySoal,
        public InterfaceRepositoryTestcase $repositoryTestcase,
        public InterfaceRepositoryPengerjaan $repositoryPengerjaan,
        public InterfaceRepositoryPengerjaanTestcase $repositoryPengerjaanTestcase,
        public InterfaceRequestServer $requestServer
    )
    {
        
    }

    public function execute(RequestSubmitPengerjaan $request) : IDPengerjaan {

        $idPengerjaan = new IDPengerjaan(null);
        $idPengsubmit = new IDUser(Auth::id());

        $sourceCode = new SourceCodePengerjaan($request->sourceCode, $request->bahasa);
        if (strlen($sourceCode->ambilSourceCode()) == 0) {
            throw new ApplicationException("source code tidak boleh kosong");
        }

        $idSoal = new IDSoal($request->idSoal);
        $soal = $this->repositorySoal->byId($idSoal);
        if ($soal === null) {
            throw new ApplicationException("soal tidak ada");
        }
        if ($soal->ambilStatusSoal()->ambilStatus() != StatusSoal::PUBLIK) {
            throw new ApplicationException("tidak dapat dikerjakan");
        }
        if ($soal->ambilIDPembuat() == $idPengsubmit) {
            throw new ApplicationException("pembuat tidak boleh submit");
        }


        $daftarTestcase = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($soal->ambilIDSoal(), $soal->ambilVersiSoal());
        $daftarToken = $this->requestServer->kirimBatchSubmissionPengerjaan($sourceCode, $daftarTestcase, $soal->ambilBatasanSoal());

        if ($daftarToken === false || count($daftarTestcase) != count($daftarToken)) {
            throw new ApplicationException("gagal menguji coba program");
        }
        
        /**
         * @var HasilSubmission[] $daftarHasilSubmission
         */
        $daftarHasilSubmission = [];
        foreach($daftarToken as $token) {
            array_push($daftarHasilSubmission, $this->requestServer->ambilHasilSubmission($token));
            $this->requestServer->hapusSubmission($token);
        }

        if (count($daftarHasilSubmission) != count($daftarTestcase)) {
            throw new ApplicationException("gagal menguji coba program");
        }

        $status = HasilPengerjaan::ACCEPTED;
        $totalWaktu = 0;
        $totalMemory = 0;
        foreach($daftarHasilSubmission as $hasilSubmission) {
            if ($hasilSubmission->ambilStatus() != "Accepted") {
                $status = HasilPengerjaan::ERROR;
            }
            $totalWaktu += $hasilSubmission->ambilWaktu();
            $totalMemory += $hasilSubmission->ambilMemori();
        }
        if ($totalWaktu > $soal->ambilBatasanSoal()->ambilBatasanWaktuTotal()) {
            $status = HasilPengerjaan::ERROR;
        }

        $pengerjaan = new Pengerjaan(
            $idPengerjaan, $idPengsubmit, $soal->ambilIDSoal(), $soal->ambilVersiSoal(), $sourceCode, 
            new HasilPengerjaan($status, $totalWaktu, $totalMemory), new DateTime("now")
        );
        $this->repositoryPengerjaan->save($pengerjaan);

        if ($status == HasilPengerjaan::ACCEPTED) {
            $soal->ambilVersiSoal()->ambilHasilSubmitSoal()->tambahSubmitBerhasil();
        }
        else {
            $soal->ambilVersiSoal()->ambilHasilSubmitSoal()->tambahSubmitGagal();
        }
        $this->repositorySoal->update($soal);

        for ($i = 0; $i < count($daftarTestcase); $i++) {
            $this->repositoryPengerjaanTestcase->save(new PengerjaanTestcase(
                $idPengerjaan,
                $daftarTestcase[$i]->ambilIDTestcase(),
                new HasilPengerjaanTestcase(
                    $daftarHasilSubmission[$i]->ambilStatus(),
                    $daftarHasilSubmission[$i]->ambilWaktu(),
                    $daftarHasilSubmission[$i]->ambilMemori()
                )
            ));
        }

        return $idPengerjaan;
    }
}

?>