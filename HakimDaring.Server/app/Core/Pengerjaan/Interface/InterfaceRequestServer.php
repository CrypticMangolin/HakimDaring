<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Interface;

use App\Core\Pengerjaan\Data\HasilSubmission;
use App\Core\Pengerjaan\Data\TokenSubmission;
use App\Core\Pengerjaan\Data\UjiCobaSourceCode;

interface InterfaceRequestServer {

    /**
     * Untuk mengirim kumpulan uji coba ke server judge
     * 
     * @param UjiCobaSourceCode $sourceCode source code yang dikirimkan beserta input uji coba
     * 
     * @return TokenSubmission[]|false TokenSubmission bila berhasil memperoleh token dari server atau false bila gagal 
     */
    public function kirimBatchSubmissionUjiCoba(UjiCobaSourceCode $sourceCode) : array|false;

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