<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Soal\Interface\InterfacePengecekJumlahTestcase;

class PengecekJumlahTestcase implements InterfacePengecekJumlahTestcase {

    public function cekTestcaseTidakMelebihiBatas(array $daftarTestcase) : bool {
        if (count($daftarTestcase) > $this::JUMLAH_MAKSIMAL_TESTCASE) {
            return false;
        }
        return true;
    }

    public function cekTestcasePublikTidakMelebihiBatas(array $daftarTestcase) : bool {
        $jumlah = 0;
        foreach($daftarTestcase as $testcase) {
            $jumlah += $testcase->apakahSoalPublik() ? 1 : 0;
            if ($jumlah > $this::JUMLAH_MAKSIMAL_TESTCASE_PUBLIK) {
                return false;
            }
        }
        return true;
    }
}

?>