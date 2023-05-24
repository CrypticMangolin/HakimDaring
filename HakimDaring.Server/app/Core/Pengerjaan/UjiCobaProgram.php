<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan;

use App\Core\Pengerjaan\Data\BahasaPemrograman;
use App\Core\Pengerjaan\Data\HasilSubmission;
use App\Core\Pengerjaan\Data\HasilUjiCoba;
use App\Core\Pengerjaan\Exception\GagalMenjalankanProgramException;
use App\Core\Pengerjaan\Interface\InterfaceRequestServer;
use App\Core\Repository\Pengerjaan\Entitas\UjiCobaSourceCode;

class UjiCobaProgram {

    private function __construct(
        private InterfaceRequestServer $requestServer
    )
    {
        
    }

    public function ujiCobaJalankanProgram(UjiCobaSourceCode $sourceCode) : array {

        $daftarToken = $this->requestServer->kirimBatchSubmissionUjiCoba($sourceCode);

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