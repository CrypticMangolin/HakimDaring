<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Interface;

use App\Core\Pengerjaan\Data\HasilSubmission;
use App\Core\Pengerjaan\Data\TokenSubmission;
use App\Core\Pengerjaan\Data\UjiCobaSourceCode;
use App\Core\Pengerjaan\Data\UjiSourceCodePengerjaan;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Testcase\Entitas\Testcase;

interface InterfaceRequestServer {

    /**
     * Untuk mengirim kumpulan uji coba ke server judge
     * 
     * @param BatasanSoal $batasan batasan sumber daya untuk program
     * @param UjiCobaSourceCode $sourceCode source code yang dikirimkan beserta input uji coba
     * 
     * @return TokenSubmission[]|false TokenSubmission bila berhasil memperoleh token dari server atau false bila gagal 
     */
    public function kirimBatchSubmissionUjiCoba(BatasanSoal $batasan, UjiCobaSourceCode $sourceCode) : array|false;

    /**
     * Untuk menguji program pengguna menggunakan input-input testcase soal dan membandingkannya dengan hasil
     * yang diharapkan 
     * 
     * @param UjiSourceCodePengerjaan $sourceCode source code yang dikirimkan beserta testcase uji coba
     * @param BatasanSoal $batasan batasan sumber daya untuk program
     * 
     * @return TokenSubmission[]|false TokenSubmission bila berhasil memperoleh token dari server atau false bila gagal 
     */
    public function kirimBatchSubmissionPengerjaan(UjiSourceCodePengerjaan $sourceCode, BatasanSoal $batasan) : array|false;

    /**
     * Untuk mengambil hasil submission
     * 
     * @param TokenSubmission $token token untuk submission
     * 
     * @return HasilSubmission hasil dari submission
     */
    public function ambilHasilSubmission(TokenSubmission $token) : HasilSubmission;

    /**
     * Untuk menghapus submission (terutama digunakan untuk submission uji coba)
     * 
     * @param TokenSubmission $token token submission yang akan dihapus
     */
    public function hapusSubmission(TokenSubmission $token) : void;
}

?>