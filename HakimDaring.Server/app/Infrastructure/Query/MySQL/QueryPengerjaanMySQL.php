<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Query\MySQL;

use App\Application\Query\Pengerjaan\HasilTestcaseDTO;
use App\Application\Query\Pengerjaan\InterfaceQueryPengerjaan;
use App\Application\Query\Pengerjaan\PengerjaanDTO;
use Illuminate\Support\Facades\DB;

class QueryPengerjaanMySQL implements InterfaceQueryPengerjaan {

    public function byId(string $idPengerjaan) : ?PengerjaanDTO {
        
        $script = "SELECT p.id_pengerjaan, p.id_user, du.nama_user, p.id_soal, s.judul, p.source_code, p.bahasa,
            p.hasil, p.total_waktu, p.total_memori, p.tanggal_submit, p.versi_soal <> s.versi AS outdated
            FROM pengerjaan AS p 
            INNER JOIN data_user AS du ON p.id_user = du.id_user
            INNER JOIN soal AS s ON s.id_soal = p.id_soal 
            WHERE p.id_pengerjaan = :id_pengerjaan";

        $hasilQuery = DB::select($script, [
            "id_pengerjaan" => $idPengerjaan
        ]);
        if (count($hasilQuery) == 0) {
            return null;
        }
        $hasil = $hasilQuery[0];

        return new PengerjaanDTO(
            $hasil->id_pengerjaan,
            $hasil->id_user,
            $hasil->nama_user,
            $hasil->id_soal,
            $hasil->judul,
            $hasil->source_code,
            $hasil->bahasa,
            $hasil->hasil,
            $hasil->total_waktu,
            $hasil->total_memori,
            $hasil->tanggal_submit,
            $hasil->outdated,
        );
    }

    public function byPengsubmitDanSoal(string $idPengsubmit, string $idSoal): array
    {
        $script = "SELECT p.id_pengerjaan, p.id_user, du.nama_user, p.id_soal, s.judul, p.source_code, p.bahasa,
            p.hasil, p.total_waktu, p.total_memori, p.tanggal_submit, p.versi_soal <> s.versi AS outdated
            FROM pengerjaan AS p 
            INNER JOIN data_user AS du ON p.id_user = du.id_user
            INNER JOIN soal AS s ON s.id_soal = p.id_soal 
            WHERE p.id_user = :id_pengsubmit AND p.id_soal = :id_soal";

        $hasilQuery = DB::select($script, [
            "id_pengsubmit" => $idPengsubmit,
            "id_soal" => $idSoal
        ]);

        /**
         * @var PengerjaanDTO[] $hasilAkhir
         */
        $hasilAkhir = [];

        foreach($hasilQuery as $hasil) {
            array_push($hasilAkhir, [
                $hasil->id_pengerjaan,
                $hasil->id_user,
                $hasil->nama_user,
                $hasil->id_soal,
                $hasil->judul,
                $hasil->source_code,
                $hasil->bahasa,
                $hasil->hasil,
                $hasil->total_waktu,
                $hasil->total_memori,
                $hasil->tanggal_submit,
                $hasil->outdated,
            ]);
        }
        return $hasilAkhir;
    }

    public function ambilHasilTestcase(string $idPengerjaan) : array {

        $script = "SELECT htp.status, htp.waktu, htp.memori FROM hasil_testcase_pengerjaan AS htp
            INNER JOIN testcase AS htp.id_testcase = t.id_testcase
            WHERE htp.id_pengerjaan = :id_pengerjaan
            ORDER BY t.urutan";

        $hasilQuery = DB::select($script, [
            "id_pengerjaan" => $idPengerjaan
        ]);

        /**
         * @var HasilTestcaseDTO[] $hasilAkhir
         */
        $hasilAkhir = [];
        foreach($hasilQuery as $hasil) {
            array_push($hasilAkhir, new HasilTestcaseDTO(
                $hasil->status,
                doubleval($hasil->waktu),
                intval($hasil->memori)
            ));
        }

        return $hasilAkhir;
    }
    
}

?>