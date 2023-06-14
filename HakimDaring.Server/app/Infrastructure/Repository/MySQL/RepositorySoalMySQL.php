<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository\MySQL;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\HasilSubmitSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\PenjelasanSoal;
use App\Core\Repository\Soal\Entitas\Soal;
use App\Core\Repository\Soal\Entitas\StatusSoal;
use App\Core\Repository\Soal\Entitas\VersiSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use Illuminate\Support\Facades\DB;

class RepositorySoalMySQL implements InterfaceRepositorySoal {

    

    public function byId(IDSoal $idSoal) : ?Soal {
        $script = "SELECT s.id_soal, s.id_user_pembuat, s.judul, s.soal, s.versi, s.status, 
            s.batasan_waktu_per_testcase_dalam_sekon, s.batasan_waktu_total_semua_testcase_dalam_sekon, 
            s.batasan_memori_dalam_kb, s.jumlah_submit, s.jumlah_berhasil, s.jumlah_report, s.id_ruangan_diskusi 
            FROM soal AS s WHERE s.id_soal = :id_soal";

        $hasilQuery = DB::select($script, [
            "id_soal" => $idSoal->ambilID()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }

        $hasil = $hasilQuery[0];
        return new Soal(
            new IDSoal($hasil->id_soal),
            new IDUser($hasil->id_user_pembuat),
            new PenjelasanSoal($hasil->judul, $hasil->soal), 
            new BatasanSoal(
                $hasil->batasan_waktu_per_testcase_dalam_sekon, 
                $hasil->batasan_waktu_total_semua_testcase_dalam_sekon, 
                $hasil->batasan_memori_dalam_kb), 
            new VersiSoal($hasil->versi, new HasilSubmitSoal($hasil->jumlah_submit, $hasil->jumlah_berhasil)), 
            new StatusSoal($hasil->status, $hasil->jumlah_report), 
            new IDRuanganComment($hasil->id_ruangan_diskusi)
        );
    }

    
    public function byJudul(PenjelasanSoal $penjelasanSoal) : ?Soal {
        $script = "SELECT s.id_soal, s.id_user_pembuat, s.judul, s.soal, s.versi, s.status, 
            s.batasan_waktu_per_testcase_dalam_sekon, s.batasan_waktu_total_semua_testcase_dalam_sekon, 
            s.batasan_memori_dalam_kb, s.jumlah_submit, s.jumlah_berhasil, s.jumlah_report, s.id_ruangan_diskusi 
            FROM soal AS s WHERE s.judul = :judul";

        $hasilQuery = DB::select($script, [
            "judul" => $penjelasanSoal->ambilJudul()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }

        $hasil = $hasilQuery[0];
        return new Soal(
            new IDSoal($hasil->id_soal),
            new IDUser($hasil->id_user_pembuat),
            new PenjelasanSoal($hasil->judul, $hasil->soal), 
            new BatasanSoal(
                $hasil->batasan_waktu_per_testcase_dalam_sekon, 
                $hasil->batasan_waktu_total_semua_testcase_dalam_sekon, 
                $hasil->batasan_memori_dalam_kb), 
            new VersiSoal($hasil->versi, new HasilSubmitSoal($hasil->jumlah_submit, $hasil->jumlah_berhasil)), 
            new StatusSoal($hasil->status, $hasil->jumlah_report), 
            new IDRuanganComment($hasil->id_ruangan_diskusi)
        );
    }

    public function save(Soal $soal) : void {
        DB::table("soal")->insert([
            "id_soal" => $soal->ambilIDSoal()->ambilID(),
            "id_user_pembuat" => $soal->ambilIDPembuat()->ambilID(),
            "judul" => $soal->ambilPenjelasanSoal()->ambilJudul(),
            "soal" => $soal->ambilPenjelasanSoal()->ambilSoal(),
            "versi" => $soal->ambilVersiSoal()->ambilVersi(),
            "status" => $soal->ambilStatusSoal()->ambilStatus(),
            "batasan_waktu_per_testcase_dalam_sekon" => $soal->ambilBatasanSoal()->ambilBatasanWaktuPerTestcase(),
            "batasan_waktu_total_semua_testcase_dalam_sekon" => $soal->ambilBatasanSoal()->ambilBatasanWaktuTotal(),
            "batasan_memori_dalam_kb" => $soal->ambilBatasanSoal()->ambilBatasanMemoriDalamKB(),
            "jumlah_submit" => $soal->ambilVersiSoal()->ambilHasilSubmitSoal()->ambilTotalSubmit(),
            "jumlah_berhasil" => $soal->ambilVersiSoal()->ambilHasilSubmitSoal()->ambilSubmitBerhasil(),
            "jumlah_report" => $soal->ambilStatusSoal()->ambilJumlahReport(),
            "id_ruangan_diskusi" => $soal->ambilIDRuanganComment()->ambilID()
        ]);
    }


    public function update(Soal $soal) : void {
        DB::table("soal")->where("id_soal", "=", $soal->ambilIDSoal()->ambilID())->update([
            "id_soal" => $soal->ambilIDSoal()->ambilID(),
            "id_user_pembuat" => $soal->ambilIDPembuat()->ambilID(),
            "judul" => $soal->ambilPenjelasanSoal()->ambilJudul(),
            "soal" => $soal->ambilPenjelasanSoal()->ambilSoal(),
            "versi" => $soal->ambilVersiSoal()->ambilVersi(),
            "status" => $soal->ambilStatusSoal()->ambilStatus(),
            "batasan_waktu_per_testcase_dalam_sekon" => $soal->ambilBatasanSoal()->ambilBatasanWaktuPerTestcase(),
            "batasan_waktu_total_semua_testcase_dalam_sekon" => $soal->ambilBatasanSoal()->ambilBatasanWaktuTotal(),
            "batasan_memori_dalam_kb" => $soal->ambilBatasanSoal()->ambilBatasanMemoriDalamKB(),
            "jumlah_submit" => $soal->ambilVersiSoal()->ambilHasilSubmitSoal()->ambilTotalSubmit(),
            "jumlah_berhasil" => $soal->ambilVersiSoal()->ambilHasilSubmitSoal()->ambilSubmitBerhasil(),
            "jumlah_report" => $soal->ambilStatusSoal()->ambilJumlahReport(),
            "id_ruangan_diskusi" => $soal->ambilIDRuanganComment()->ambilID()
        ]);
    }
}

?>