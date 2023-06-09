<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan;

use App\Core\Pengerjaan\Data\BahasaPemrograman;
use App\Core\Pengerjaan\Data\HasilSubmission;
use App\Core\Pengerjaan\Data\PengerjaanSourceCode;
use App\Core\Pengerjaan\Data\UjiSourceCodePengerjaan;
use App\Core\Pengerjaan\Exception\GagalSubmitProgramException;
use App\Core\Pengerjaan\Interfaces\InterfaceRequestServer;
use App\Core\Pengerjaan\Interfaces\InterfaceSubmitPengerjaanProgram;
use App\Core\Repository\Pengerjaan\Entitas\DataPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\IDPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\PengerjaanTestcase;
use App\Core\Repository\Pengerjaan\InterfaceRepositoryPengerjaan;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\Entitas\Testcase;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use DateTime;

class SubmitPengerjaanProgram implements InterfaceSubmitPengerjaanProgram {

    public function __construct(
        private InterfaceRepositorySoal $repositorySoal,
        private InterfaceRepositoryTestcase $repositoryTestcase,
        private InterfaceRepositoryPengerjaan $repositoryPengerjaan,
        private InterfaceRequestServer $requestServer
    )
    {
        
    }

    public function submitProgram(PengerjaanSourceCode $pengerjaanSourceCode) : IDPengerjaan {

        if (strlen($pengerjaanSourceCode->ambilSourceCode()) == 0) {
            throw new GagalSubmitProgramException("Source code kosong");
        }

        $informasiSoal = $this->repositorySoal->ambilInformasiSoal($pengerjaanSourceCode->ambilIDSoal());

        if ($informasiSoal == null) {
            throw new GagalSubmitProgramException("Soal tidak ada");
        }

        $idPembuatSoal = $this->repositorySoal->ambilIDPembuatSoal($pengerjaanSourceCode->ambilIDSoal());

        if ($idPembuatSoal != null && $pengerjaanSourceCode->ambilIDPembuat() == $idPembuatSoal) {
            throw new GagalSubmitProgramException("Pembuat soal tidak boleh melakukan submit pada soal milik sendiri");
        }

        $daftarTestcase = $this->repositoryTestcase->ambilKumpulanTestcaseDariSoal($informasiSoal->ambilSoal()->ambilIDSoal(), new VersiSoal($informasiSoal->ambilVersi()));
        
        $kumpulanTestcase = [];
        foreach($daftarTestcase as $testcase) {
            array_push($kumpulanTestcase, 
                new Testcase(
                    $testcase->ambilDataTestcase()->ambilTestcase()->ambilTestcase(), 
                    $testcase->ambilDataTestcase()->ambilTestcase()->ambilJawaban()
                )
            );
        }

        $daftarToken = $this->requestServer->kirimBatchSubmissionPengerjaan(
            new UjiSourceCodePengerjaan(
                $pengerjaanSourceCode->ambilSourceCode(),
                $pengerjaanSourceCode->ambilBahasa(),
                $kumpulanTestcase
            ),
            new BatasanSoal(
                $informasiSoal->ambilBatasanWaktuPerTestcase(),
                $informasiSoal->ambilBatasanWaktuTotal(),
                $informasiSoal->ambilBatasanMemoriDalamKB()
            ) 
        );

        if ($daftarToken === false) {
            throw new GagalSubmitProgramException("Gagal submit program");
        }

        if (count($daftarTestcase) != count($daftarToken)) {
            throw new GagalSubmitProgramException("Gagal submit program");
        }

        $daftarHasilSubmission = [];
        foreach($daftarToken as $token) {
            array_push($daftarHasilSubmission, $this->requestServer->ambilHasilSubmission($token));
            $this->requestServer->hapusSubmission($token);
        }

        if (count($daftarHasilSubmission) != count($kumpulanTestcase)) {
            throw new GagalSubmitProgramException("Kesalahan pada server");
        }

        $status = "Selesai";
        $totalWaktu = 0;
        $totalMemory = 0;
        foreach($daftarHasilSubmission as $hasilSubmission) {
            if ($hasilSubmission instanceof HasilSubmission) {
                if ($hasilSubmission->ambilStatus() != "Accepted") {
                    $status = "Salah";
                }
                $totalWaktu += $hasilSubmission->ambilWaktu();
                $totalMemory += $hasilSubmission->ambilMemori();
            }
            else {
                throw new GagalSubmitProgramException("Kesalahan pada server");
            }
        }

        if ($totalWaktu > $informasiSoal->ambilBatasanWaktuTotal()) {
            $status = "Melebihi batas waktu";
        }

        $idPengerjaan = $this->repositoryPengerjaan->simpanPengerjaan(
            new DataPengerjaan(
                $pengerjaanSourceCode->ambilIDPembuat(),
                $pengerjaanSourceCode->ambilIDSoal(),
                new VersiSoal($informasiSoal->ambilVersi()),
                $pengerjaanSourceCode->ambilSourceCode(),
                array_search($pengerjaanSourceCode->ambilBahasa(), BahasaPemrograman::MAPPING),
                $status,
                $totalWaktu,
                $totalMemory,
                new DateTime()
            )
        );

        $this->repositorySoal->tambahSubmission($pengerjaanSourceCode->ambilIDSoal(), $status == "Selesai");

        
        $daftarPengerjaanTestcase = [];
        for ($i = 0; $i < count($daftarTestcase); $i++) {
            array_push($daftarPengerjaanTestcase, new PengerjaanTestcase(
                $idPengerjaan,
                $daftarTestcase[$i]->ambilIDTestcase(),
                $daftarHasilSubmission[$i]->ambilStatus(),
                $daftarHasilSubmission[$i]->ambilWaktu(),
                $daftarHasilSubmission[$i]->ambilMemori()
            ));
        }

        $this->repositoryPengerjaan->simpanPengerjaanTestcase($daftarPengerjaanTestcase);

        return $idPengerjaan;
    }
}

?>