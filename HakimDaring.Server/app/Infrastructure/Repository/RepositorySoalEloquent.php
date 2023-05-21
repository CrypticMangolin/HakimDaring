<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\DataSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\InformasiSoal;
use App\Core\Repository\Soal\Entitas\Soal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use Illuminate\Support\Facades\DB;

class RepositorySoalEloquent implements InterfaceRepositorySoal {

    public function buatSoal(IDUser $idUSer, DataSoal $dataSoal) : IDSoal {

        $dataBaru = [
            "id_user_pembuat" => $idUSer->ambilID(),
            "judul" => $dataSoal->ambilJudul(),
            "soal" => $dataSoal->ambilSoal(),
            "versi" => 0,
            "status" => "publik",
            "batasan_waktu_per_testcase_dalam_sekon" => 1,
            "batasan_waktu_total_semua_testcase_dalam_sekon" => 10,
            "batasan_memori_dalam_kb" => 128000,
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

    public function ambilInformasiSoal(IDSoal $idSoal) : ?InformasiSoal {
        $scriptQuery = "SELECT s.id, s.judul, s.soal, s.versi, s.status, 
            s.batasan_waktu_per_testcase_dalam_sekon, s.batasan_waktu_total_semua_testcase_dalam_sekon,
            s.batasan_memori_dalam_kb, s.jumlah_submit, s.jumlah_berhasil
            FROM soal as s WHERE id = :id_soal";

        $hasilQuery = DB::select($scriptQuery, [
            "id_soal" => $idSoal->ambilID()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }

        return new InformasiSoal(
            $idSoal,
            $hasilQuery[0]->judul,
            $hasilQuery[0]->soal,
            $hasilQuery[0]->versi,
            $hasilQuery[0]->status,
            $hasilQuery[0]->batasan_waktu_per_testcase_dalam_sekon,
            $hasilQuery[0]->batasan_waktu_total_semua_testcase_dalam_sekon,
            $hasilQuery[0]->batasan_memori_dalam_kb,
            $hasilQuery[0]->jumlah_submit,
            $hasilQuery[0]->jumlah_berhasil
        );
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

    public function ambilBatasanSumberDaya(IDSoal $idSoal) : ?BatasanSoal {
        $scriptQuery = "SELECT s.batasan_waktu_per_testcase_dalam_sekon,
            s.batasan_waktu_total_semua_testcase_dalam_sekon, s.batasan_memori_dalam_kb
            FROM soal as s WHERE s.id = :id_soal";

        $hasilQuery = DB::select($scriptQuery, [
            "id_soal" => $idSoal->ambilID()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }
        return new BatasanSoal(
            $hasilQuery[0]->batasan_waktu_per_testcase_dalam_sekon,
            $hasilQuery[0]->batasan_waktu_total_semua_testcase_dalam_sekon,
            $hasilQuery[0]->batasan_memori_dalam_kb
        );
    }

    public function setBatasanSoal(IDSoal $idSoal, BatasanSoal $batasanBaru) : void {
        $scriptQuery = "UPDATE soal SET 
            batasan_waktu_per_testcase_dalam_sekon = :batasan_waktu_per_testcase_dalam_sekon, 
            batasan_waktu_total_semua_testcase_dalam_sekon = :batasan_waktu_total_semua_testcase_dalam_sekon,
            batasan_memori_dalam_kb = :batasan_memori_dalam_kb
            WHERE id = :id_soal";

        DB::update($scriptQuery, [
            "batasan_waktu_per_testcase_dalam_sekon" => $batasanBaru->ambilBatasanWaktuPerTestcase(),
            "batasan_waktu_total_semua_testcase_dalam_sekon" => $batasanBaru->ambilBatasanWaktuTotal(),
            "batasan_memori_dalam_kb" => $batasanBaru->ambilBatasanMemoriDalamKB(),
            "id_soal" => $idSoal->ambilID()
        ]);
    }
}

?>