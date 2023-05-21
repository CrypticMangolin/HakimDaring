<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use App\Core\Repository\Testcase\Entitas\TestcaseData;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use ErrorException;
use Illuminate\Support\Facades\DB;

class RepositoryTestcaseEloquent implements InterfaceRepositoryTestcase {
    
    public function ambilKumpulanTestcaseDariSoal(IDSoal $idSoal, VersiSoal $versiSoal) : array {
        $scriptQuery = "SELECT t.testcase, t.jawaban, t.urutan, t.publik FROM testcase AS t 
            WHERE t.id_soal = :id_soal AND t.versi_soal = :versi_soal"
        ;
        
        $kumpulanHasilQuery = DB::select($scriptQuery, [
            "id_soal" => $idSoal->ambilID(),
            "versi_soal" => $versiSoal->ambilVersi()
        ]);

        $hasil = [];
        foreach($kumpulanHasilQuery as $hasilQuery) {
            array_push($hasil, new TestcaseData(
                $hasilQuery->testcase,
                $hasilQuery->jawaban,
                $hasilQuery->urutan,
                $hasilQuery->publik == 1
            ));
        }

        return $hasil;
    }

    public function setTestcaseUntukSoal(IDSoal $idSoal, VersiSoal $versiSoal, array $kumpulanTestcase) : void {
        $dataUntukDatabase = [];
        foreach($kumpulanTestcase as $testcase) {
            array_push($dataUntukDatabase, [
                "id_soal" => $idSoal->ambilID(),
                "testcase" => $testcase->ambilTestcase(),
                "jawaban" => $testcase->ambilJawaban(),
                "urutan" => $testcase->ambilUrutan(),
                "publik" => $testcase->apakahSoalPublik(),
                "versi_soal" => $versiSoal->ambilVersi()
            ]);
        }
        
        DB::table("testcase")->insert($dataUntukDatabase);
    }
}

?>