<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Query\MySQL;

use App\Application\Query\Soal\InterfaceQuerySoal;
use App\Application\Query\Soal\SoalDTO;
use Illuminate\Support\Facades\DB;

class QuerySoalMySQL implements InterfaceQuerySoal {

    
    public function byID(string $idSoal) : ?SoalDTO {
        $script = "SELECT s.id_soal, s.id_user_pembuat, s.judul, s.soal, s.versi, s.status, 
            s.batasan_waktu_per_testcase_dalam_sekon, s.batasan_waktu_total_semua_testcase_dalam_sekon, 
            s.batasan_memori_dalam_kb, s.jumlah_submit, s.jumlah_berhasil, s.id_ruangan_diskusi, du.nama_user
            FROM soal AS s
            INNER JOIN data_user AS du ON du.id_user = s.id_user_pembuat WHERE s.id_soal = :id_soal";

        $hasilQuery = DB::select($script, [
            "id_soal" => $idSoal
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }

        $hasil = $hasilQuery[0];
        return new SoalDTO(
            $hasil->id_soal,
            $hasil->judul,
            $hasil->soal,
            $hasil->batasan_waktu_per_testcase_dalam_sekon,
            $hasil->batasan_waktu_total_semua_testcase_dalam_sekon,
            $hasil->batasan_memori_dalam_kb,
            $hasil->jumlah_submit,
            $hasil->jumlah_berhasil,
            $hasil->status,
            $hasil->id_ruangan_diskusi,
            $hasil->id_user_pembuat,
            $hasil->nama_user
        );
    }
}

?>