<?php 

declare(strict_types = 1);

namespace App\Core\Services\Pengerjaan;

use App\Core\Repository\Pengerjaan\Entitas\HasilSubmission;
use App\Core\Repository\Pengerjaan\Entitas\SourceCodePengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\TokenSubmission;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Testcase\Entitas\SoalTestcase;
use App\Core\Repository\Testcase\Entitas\Testcase;

interface InterfaceRequestServer {

    /**
     * @param SoalTestcase[] $daftarTestcase
     * @return TokenSubmission[]|false
     */
    public function kirimBatchSubmissionUjiCoba(SourceCodePengerjaan $sourceCode, array $daftarTestcase, BatasanSoal $batasan) : array|false;

    /**
     * @param Testcase[] $daftarTestcase
     * @return TokenSubmission[]|false
     */
    public function kirimBatchSubmissionPengerjaan(SourceCodePengerjaan $sourceCode, array $daftarTestcase, BatasanSoal $batasan) : array|false;

    public function ambilHasilSubmission(TokenSubmission $token) : HasilSubmission;

    public function hapusSubmission(TokenSubmission $token) : void;
}

?>