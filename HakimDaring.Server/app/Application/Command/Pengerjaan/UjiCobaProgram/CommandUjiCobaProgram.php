<?php 

declare(strict_types = 1);

namespace App\Application\Command\Pengerjaan\UjiCobaProgram;

use App\Application\Exception\ApplicationException;
use App\Core\Repository\Pengerjaan\Entitas\HasilSubmission;
use App\Core\Repository\Pengerjaan\Entitas\SourceCodePengerjaan;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\StatusSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\Entitas\SoalTestcase;
use App\Core\Services\Pengerjaan\BahasaPemrograman;
use App\Core\Services\Pengerjaan\InterfaceRequestServer;

class CommandUjiCobaProgram {

    public function __construct(
        public InterfaceRequestServer $requestServer,
        public InterfaceRepositorySoal $repositorySoal
    )
    {
        
    }

    /**
     * @return HasilSubmission[]
     */
    public function execute(RequestUjiCobaProgram $request) : array {
        if (strlen($request->sourceCode) == 0) {
            throw new ApplicationException("source code tidak boleh kosong");
        }
        
        if (count($request->daftarInput) == 0) {
            throw new ApplicationException("daftar input tidak boleh kosong");
        }
        
        if (count($request->daftarInput) > 6) {
            throw new ApplicationException("daftar input maksimal 6");
        }
        
        if (!array_key_exists($request->bahasa, BahasaPemrograman::MAPPING)) {
            throw new ApplicationException("bahasa tidak ada");
        }

        $idSoal = new IDSoal($request->idSoal);
        $soal = $this->repositorySoal->byId($idSoal);
        
        if ($soal === null) {
            throw new ApplicationException("soal tidak ada");
        }
        if ($soal->ambilStatusSoal()->ambilStatus() != StatusSoal::PUBLIK) {
            throw new ApplicationException("tidak dapat dikerjakan");
        }
        
        $sourceCodeProgram = new SourceCodePengerjaan($request->sourceCode, $request->bahasa);
        $daftarTestcase = [];
        foreach($request->daftarInput as $stdin) {
            array_push($daftarTestcase, new SoalTestcase($stdin));
        }

        $daftarToken = $this->requestServer->kirimBatchSubmissionUjiCoba($sourceCodeProgram, $daftarTestcase, $soal->ambilBatasanSoal());

        if ($daftarToken === false) {
            throw new ApplicationException("gagal menguji coba program");
        }

        $daftarHasilSubmission = [];
        foreach($daftarToken as $token) {
            array_push($daftarHasilSubmission, $this->requestServer->ambilHasilSubmission($token));
            $this->requestServer->hapusSubmission($token);
        }

        return $daftarHasilSubmission;
        
    }
}

?>