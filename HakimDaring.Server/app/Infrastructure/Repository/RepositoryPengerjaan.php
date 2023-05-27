<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Pengerjaan\Entitas\DataPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\IDPengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\Pengerjaan;
use App\Core\Repository\Pengerjaan\Entitas\PengerjaanTestcase;
use App\Core\Repository\Pengerjaan\InterfaceRepositoryPengerjaan;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use App\Core\Repository\Testcase\Entitas\IDTestcase;
use DateTime;
use Illuminate\Support\Facades\DB;

class RepositoryPengerjaan implements InterfaceRepositoryPengerjaan {

    public function simpanPengerjaan(DataPengerjaan $dataPengerjaan) : IDPengerjaan {

        $dataBaru = [
            "id_user" => $dataPengerjaan->ambilIDPembuat()->ambilID(),
            "id_soal" => $dataPengerjaan->ambilIDSoal()->ambilID(),
            "versi_soal" => $dataPengerjaan->ambilVersiSoal()->ambilVersi(),
            "source_code" => $dataPengerjaan->ambilSourceCode(),
            "bahasa" => $dataPengerjaan->ambilBahasa(),
            "hasil" => $dataPengerjaan->ambilHasil(),
            "total_waktu" => $dataPengerjaan->ambilTotalWaktu(),
            "total_memori" => $dataPengerjaan->ambilTotalMemori(),
            "tanggal_submit" => $dataPengerjaan->ambilTanggalSubmit()->format("Y-m-d H:i:s")
        ];

        $idPengerjaan = DB::table("pengerjaan")->insertGetId($dataBaru);

        return new IDPengerjaan($idPengerjaan);
    }

    
    public function simpanPengerjaanTestcase(array $daftarPengerjaanTestcase) : void {
        
        $dataBaru = [];
        foreach($daftarPengerjaanTestcase as $pengerjaanTestcase) {
            array_push($dataBaru, [
                "id_pengerjaan" => $pengerjaanTestcase->ambilIDPengerjaan()->ambilID(),
                "id_testcase" => $pengerjaanTestcase->ambilIDTestcase()->ambilID(),
                "status" => $pengerjaanTestcase->ambilStatus(),
                "waktu" => $pengerjaanTestcase->ambilWaktu(),
                "memori" => $pengerjaanTestcase->ambilMemori()
            ]);
        }

        DB::table("hasil_testcase_pengerjaan")->insert($dataBaru);
    }
    
    public function ambilPengerjaan(IDPengerjaan $idPengerjaan) : ?Pengerjaan {

        $scriptQuery = "SELECT p.id_user, p.id_soal, p.versi_soal, p.source_code, p.bahasa, p.hasil, p.total_waktu, p.total_memori, p.tanggal_submit 
            FROM pengerjaan AS p WHERE p.id = :id_pengerjaan";

        $hasilQuery = DB::select($scriptQuery,[
            "id_pengerjaan" => $idPengerjaan->ambilID()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }

        return new Pengerjaan(
            $idPengerjaan,
            new DataPengerjaan(
                new IDUser($hasilQuery[0]->id_user),
                new IDSoal($hasilQuery[0]->id_soal),
                new VersiSoal($hasilQuery[0]->versi_soal),
                $hasilQuery[0]->source_code,
                $hasilQuery[0]->bahasa,
                $hasilQuery[0]->hasil,
                $hasilQuery[0]->total_waktu,
                $hasilQuery[0]->total_memori,
                DateTime::createFromFormat("Y-m-d H:i:s", $hasilQuery[0]->tanggal_submit)
            )
        );
    }
    
    public function ambilPengerjaanTestcase(IDPengerjaan $idPengerjaan) : array {
        $scriptQuery = "SELECT p.id_pengerjaan, p.id_testcase, p.status, p.waktu, p.memori  FROM (
                SELECT htp.id_pengerjaan, htp.id_testcase, htp.status, htp.waktu, htp.memori
                FROM hasil_testcase_pengerjaan AS htp WHERE htp.id_pengerjaan = :id_pengerjaan
            ) AS p 
            INNER JOIN testcase AS t ON t.id = p.id_testcase 
            ORDER BY t.urutan ASC";

        $hasilQuery = DB::select($scriptQuery, [
            "id_pengerjaan" => $idPengerjaan->ambilID()
        ]);

        $hasil = [];

        foreach($hasilQuery as $h) {
            array_push($hasil, new PengerjaanTestcase(
                $idPengerjaan,
                new IDTestcase($h->id_testcase),
                $h->status,
                $h->waktu,
                $h->memori
            ));
        }

        return $hasil;
    }
}

?>