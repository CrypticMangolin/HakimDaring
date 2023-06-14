<?php 

declare(strict_types = 1);

namespace App\Core\Services\Soal;

use App\Core\Repository\Testcase\Entitas\PublisitasTestcase;
use App\Core\Repository\Testcase\Entitas\Testcase;

class PengecekJumlahTestcase {

    const JUMLAH_MAKSIMAL_TESTCASE = 20;
    const JUMLAH_MAKSIMAL_TESTCASE_PUBLIK = 5;

    /**
     * @param Testcase[] $daftarTestcase
     */
    public function cekTestcaseTidakMelebihiBatas(array $daftarTestcase) : bool {
        if (count($daftarTestcase) > $this::JUMLAH_MAKSIMAL_TESTCASE) {
            return false;
        }
        return true;
    }

    /**
     * @param Testcase[] $daftarTestcase
     */
    public function cekTestcasePublikTidakMelebihiBatas(array $daftarTestcase) : bool {
        $jumlah = 0;
        foreach($daftarTestcase as $testcase) {
            $jumlah += $testcase->ambilPublisitasTestcase()->ambilpublisitas() == PublisitasTestcase::PUBLIK ? 1 : 0;
            if ($jumlah > $this::JUMLAH_MAKSIMAL_TESTCASE_PUBLIK) {
                return false;
            }
        }
        return true;
    }
}

?>