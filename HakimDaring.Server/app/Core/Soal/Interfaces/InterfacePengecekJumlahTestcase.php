<?php 

declare(strict_types = 1);

namespace App\Core\Soal\Interfaces;

use App\Core\Repository\Testcase\Entitas\TestcaseData;
use App\Core\Soal\Exception\JumlahTestcaseMelebihiBatas;

interface InterfacePengecekJumlahTestcase {

    public const JUMLAH_MAKSIMAL_TESTCASE = 20;
    public const JUMLAH_MAKSIMAL_TESTCASE_PUBLIK = 5;

    /**
     * Untuk mengecek apakah jumlah testcase tidak melebihi batas
     * 
     * @param TestcaseData[] $daftarTestcase daftar testcase yang akan di cek jumlahnya
     * 
     * @return bool true bila jumlah tidak melebihi batas
     */
    public function cekTestcaseTidakMelebihiBatas(array $daftarTestcase) : bool;

    /**
     * Untuk mengecek apakah jumlah testcase yang publik tidak melebihi batas
     * 
     * @param TestcaseData[] $daftarTestcase daftar testcase yang akan di cek jumlahnya
     * 
     * @return bool true bila jumlah testcase publik tidak melebihi batas
     */
    public function cekTestcasePublikTidakMelebihiBatas(array $daftarTestcase) : bool;
}

?>