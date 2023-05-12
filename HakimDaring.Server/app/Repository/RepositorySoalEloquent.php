<?php 

declare(strict_types = 1);

namespace App\Repository;

use App\Core\Repository\Data\DataSoal;
use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\Soal;
use App\Core\Repository\Data\VersiSoal;
use App\Core\Repository\InterfaceRepositorySoal;
use Illuminate\Support\Facades\DB;

class RepositorySoalEloquent implements InterfaceRepositorySoal {

    public function buatSoal(IDUser $idUSer, DataSoal $dataSoal) : IDSoal {

        $dataBaru = [
            "id_user_pembuat" => $idUSer->ambilID(),
            "judul" => $dataSoal->ambilJudul(),
            "soal" => $dataSoal->ambilSoal(),
            "versi" => 0,
            "status" => "publik",
            "batasan_waktu_per_testcase_dalam_sekon" => $dataSoal->ambilBatasanWaktuPerTestcase(),
            "batasan_waktu_total_semua_testcase_dalam_sekon" => $dataSoal->ambilBatasanWaktuTotal(),
            "batasan_memori_dalam_kb" => $dataSoal->ambilBatasanMemoriDalamKB(),
            "jumlah_submit" => 0,
            "jumlah_berhasil" => 0
        ];

        $id = DB::table("soal")->insertGetId($dataBaru);

        return new IDSoal($id);
    }

    public function cekApakahJudulSudahDipakai(string $judul) : bool {
        $scriptQuery = "SELECT s.id FROM soal AS s 
            WHERE s.judul = :judul_soal"
        ;

        $hasilQuery = DB::select($scriptQuery, [
            "judul_soal" => $judul
        ]);

        return count($hasilQuery) > 0;
    }

    public function hapusSoal(IDSoal $idSoal) : void {
        $scriptQuery = "UPDATE soal SET status = :status WHERE id = :id_soal";

        DB::update($scriptQuery, [
            "status" => "dihapus",
            "id_soal" => $idSoal->ambilID()
        ]);
    }

    public function ubahSoal(Soal $soal) : void {
        $scriptQuery = "UPDATE soal SET judul = :judul_soal, soal = :soal WHERE id = :id_soal";

        DB::update($scriptQuery, [
            "judul_soal" => $soal->ambilJudul(),
            "soal" => $soal->ambilSoal(),
            "id_soal" => $soal->ambilIDSoal()->ambilID()
        ]);
    }

    public function ambilIDPembuatSoal(IDSoal $idSoal) : ?IDUser {
        $scriptQuery = "SELECT s.id_user_pembuat FROM soal as s WHERE s.id = :id_soal";

        $hasilQuery = DB::select($scriptQuery, [
            "id_soal" => $idSoal->ambilID()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }
        return new IDUser($hasilQuery[0]->id_user_pembuat);
    }

    public function ambilVersiSoal(IDSoal $idSoal) : ?VersiSoal {
        $scriptQuery = "SELECT s.versi FROM soal as s WHERE s.id = :id_soal";

        $hasilQuery = DB::select($scriptQuery, [
            "id_soal" => $idSoal->ambilID()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }
        return new VersiSoal($hasilQuery[0]->versi);
    }

    public function tambahVersiSoal(IDSoal $idSoal) : void {
        $scriptQuery = "UPDATE soal SET versi = versi + 1, jumlah_submit = 0, jumlah_berhasil = 0 WHERE id = :id_soal";

        DB::update($scriptQuery, [
            "id_soal" => $idSoal->ambilID()
        ]);
    }
}

?>