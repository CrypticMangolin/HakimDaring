<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Query\MySQL;

use App\Application\Query\Pencarian\HasilPencarianDTO;
use App\Application\Query\Pencarian\HasilPencarianSoalDTO;
use App\Application\Query\Pencarian\InterfaceQueryPencarian;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class QueryPencarianMySQL implements InterfaceQueryPencarian {


    private function buildQueryPencarian(string $judul) : Builder {
        $query = DB::table("soal")->selectRaw("id_soal, judul, jumlah_submit, jumlah_berhasil, IF(jumlah_submit > 0, jumlah_berhasil/jumlah_submit, 0) AS persentase_berhasil")
            ->where("judul", "LIKE",  "%".$judul."%");
        return $query;
    }

    public function cariSoal(int $halaman, string $judul, string $sortBy, bool $reverse) : HasilPencarianDTO {
        $query = $this->buildQueryPencarian($judul)->orderBy(
            $sortBy, $reverse ? "desc" : "asc"
        );
        $jumlahSoal = $query->count();
        $totalHalaman = (int)ceil(((float)$jumlahSoal)/((float)self::JUMLAH_PERHALAMAN));

        $hasilPencarian = $query->limit(self::JUMLAH_PERHALAMAN)->offset(self::JUMLAH_PERHALAMAN * ($halaman - 1))->get();

        /**
         * @var HasilPencarianSoalDTO[] $daftarHasilpencarian
         */
        $daftarHasilpencarian = [];
        foreach($hasilPencarian as $hasil) {
            array_push($daftarHasilpencarian, new HasilPencarianSoalDTO(
                $hasil->id_soal,
                $hasil->judul,
                $hasil->jumlah_submit,
                $hasil->jumlah_berhasil,
                $hasil->persentase_berhasil
            ));
        }

        return new HasilPencarianDTO($halaman, $totalHalaman, $daftarHasilpencarian);
    }
}

?>