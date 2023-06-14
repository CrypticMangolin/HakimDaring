<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository\MySQL;

use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use App\Core\Repository\Testcase\Entitas\IDTestcase;
use App\Core\Repository\Testcase\Entitas\JawabanTestcase;
use App\Core\Repository\Testcase\Entitas\PublisitasTestcase;
use App\Core\Repository\Testcase\Entitas\SoalTestcase;
use App\Core\Repository\Testcase\Entitas\Testcase;
use App\Core\Repository\Testcase\Entitas\UrutanTestcase;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use Illuminate\Support\Facades\DB;

class RepositoryTestcaseMySQL implements InterfaceRepositoryTestcase {
    
    public function ambilKumpulanTestcaseDariSoal(IDSoal $idSoal, VersiSoal $versiSoal) : array {
        $scriptQuery = "SELECT t.id_testcase, t.testcase, t.jawaban, t.urutan, t.publik FROM testcase AS t 
            WHERE t.id_soal = :id_soal AND t.versi_soal = :versi_soal"
        ;
        
        $kumpulanHasilQuery = DB::select($scriptQuery, [
            "id_soal" => $idSoal->ambilID(),
            "versi_soal" => $versiSoal->ambilVersi()
        ]);

        $hasil = [];
        foreach($kumpulanHasilQuery as $hasilQuery) {
            array_push($hasil, new Testcase(
                new IDTestcase($hasilQuery->id_testcase),
                $idSoal,
                new SoalTestcase($hasilQuery->testcase),
                new JawabanTestcase($hasilQuery->jawaban),
                new UrutanTestcase($hasilQuery->urutan),
                new PublisitasTestcase($hasilQuery->publik ? PublisitasTestcase::PUBLIK : PublisitasTestcase::PRIVATE)
            ));
        }

        return $hasil;
    }

    public function setTestcaseUntukSoal(IDSoal $idSoal, VersiSoal $versiSoal, array $kumpulanTestcase) : void {
        $dataUntukDatabase = [];
        foreach($kumpulanTestcase as $testcase) {
            array_push($dataUntukDatabase, [
                
                "id_testcase" => $testcase->ambilIDTestcase()->ambilID(),
                "id_soal" => $idSoal->ambilID(),
                "testcase" => $testcase->ambilSoalTestcase()->ambilSoal(),
                "jawaban" => $testcase->ambilJawabanTestcase()->ambilJawaban(),
                "urutan" => $testcase->ambilUrutanTestcase()->ambilUrutan(),
                "publik" => $testcase->ambilPublisitasTestcase()->ambilpublisitas() == PublisitasTestcase::PUBLIK,
                "versi_soal" => $versiSoal->ambilVersi()
            ]);
        }
        
        DB::table("testcase")->insert($dataUntukDatabase);
    }
}

?>