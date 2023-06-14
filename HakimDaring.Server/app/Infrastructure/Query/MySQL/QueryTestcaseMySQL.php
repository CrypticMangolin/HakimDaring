<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Query\MySQL;

use App\Application\Query\Testcase\InterfaceQueryTestcase;
use App\Application\Query\Testcase\TestcaseDTO;
use Illuminate\Support\Facades\DB;

class QueryTestcaseMySQL implements InterfaceQueryTestcase{

    public function ambilTestcasePublik(string $idSoal) : array {
        $script = "SELECT t.testcase, t.jawaban, t.urutan FROM testcase AS t 
            INNER JOIN soal AS s ON t.id_soal = s.id_soal
            WHERE t.versi_soal = s.versi AND t.id_soal = :id_soal AND t.publik = TRUE
            ORDER BY t.urutan ASC";

        $hasilQuery = DB::select($script, [
            "id_soal" => $idSoal
        ]);

        $hasilAkhir = [];

        foreach($hasilQuery as $hasil) {
            array_push($hasilAkhir, new TestcaseDTO(
                $hasil->testcase,
                $hasil->jawaban,
                true,
                intval($hasil->urutan)
            ));
        }

        return $hasilAkhir;
    }

    
    public function ambilSemuaTestcase(string $idSoal) : array {
        $script = "SELECT t.testcase, t.jawaban, t.publik, t.urutan FROM testcase AS t 
            INNER JOIN soal AS s ON t.id_soal = s.id_soal
            WHERE t.versi_soal = s.versi AND t.id_soal = :id_soal
            ORDER BY t.urutan ASC";

        $hasilQuery = DB::select($script, [
            "id_soal" => $idSoal
        ]);

        $hasilAkhir = [];

        foreach($hasilQuery as $hasil) {
            array_push($hasilAkhir, new TestcaseDTO(
                $hasil->testcase,
                $hasil->jawaban,
                boolval($hasil->publik),
                intval($hasil->urutan)
            ));
        }

        return $hasilAkhir;
    }
}

?>