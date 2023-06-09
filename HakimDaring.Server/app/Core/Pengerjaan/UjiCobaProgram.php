<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan;

use App\Core\Pengerjaan\Data\UjiCobaSourceCode;
use App\Core\Pengerjaan\Exception\GagalMenjalankanProgramException;
use App\Core\Pengerjaan\Interfaces\InterfaceRequestServer;
use App\Core\Pengerjaan\Interfaces\InterfaceUjiCobaProgram;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;

class UjiCobaProgram implements InterfaceUjiCobaProgram {

    public function __construct(
        private InterfaceRequestServer $requestServer,
        private InterfaceRepositorySoal $repositorySoal,
    )
    {
        
    }

    public function ujiCobaJalankanProgram(IDSoal $idSoal, UjiCobaSourceCode $sourceCode) : array {

        if (strlen($sourceCode->ambilSourceCode()) == 0) {
            throw new GagalMenjalankanProgramException("source code tidak boleh kosong");
        }
        
        if (count($sourceCode->ambilDaftarInput()) == 0) {
            throw new GagalMenjalankanProgramException("daftar input tidak boleh kosong");
        }
        
        if (count($sourceCode->ambilDaftarInput()) > 6) {
            throw new GagalMenjalankanProgramException("daftar input maksimal 6");
        }

        $batasanSoal = $this->repositorySoal->ambilBatasanSumberDaya($idSoal);

        if ($batasanSoal == null) {
            throw new GagalMenjalankanProgramException("Soal tidak ada");
        }

        $daftarToken = $this->requestServer->kirimBatchSubmissionUjiCoba($batasanSoal, $sourceCode);

        if ($daftarToken === false) {
            throw new GagalMenjalankanProgramException();
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