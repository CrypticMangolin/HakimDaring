<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository\MySQL;

use App\Core\Repository\DaftarSoal\Entitas\HasilPencarianSoal;
use App\Core\Repository\DaftarSoal\Entitas\KategoriPencarian;
use App\Core\Repository\DaftarSoal\InterfaceRepositoryDaftarSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Infrastructure\MapperSortBy;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class RepositoryDaftarSoalMySQL implements InterfaceRepositoryDaftarSoal {

    private MapperSortBy $mapper;

    public function __construct(MapperSortBy $mapper)
    {
        if ($mapper == null) {
            throw new InvalidArgumentException("mapper bernilai null");
        }
        $this->mapper = $mapper;
    }

    private function buildQueryPencarian(KategoriPencarian $syaratPencarian) : Builder {
        $query = DB::table("soal")->selectRaw("id, judul, jumlah_submit, jumlah_berhasil, IF(jumlah_submit > 0, jumlah_berhasil/jumlah_submit, 0) AS persentase_berhasil")
            ->where("judul", "LIKE",  "%".$syaratPencarian->ambilKataKunciJudul()."%");
        return $query;
    }

    public function ambilDaftarSoalHalaman(int $halaman, KategoriPencarian $syaratPencarian) : array {
        $sortby = $syaratPencarian->ambilSortBy();
        $query = $this->buildQueryPencarian($syaratPencarian)->orderBy(
            $this->mapper->mapSortBy($sortby), $sortby->apakahReverse() ? "desc" : "asc"
        );
        
        $hasil = $query->limit(self::JUMLAH_PERHALAMAN)->offset(self::JUMLAH_PERHALAMAN * ($halaman - 1))->get();

        $daftarHasilpencarian = [];
        foreach($hasil as $hasilPencarian) {
            array_push($daftarHasilpencarian, new HasilPencarianSoal(
                new IDSoal($hasilPencarian->id),
                $hasilPencarian->judul,
                $hasilPencarian->jumlah_submit,
                $hasilPencarian->jumlah_berhasil,
                (float)$hasilPencarian->persentase_berhasil
            ));
        }

        return $daftarHasilpencarian;
    }

    public function ambilTotalHalaman(KategoriPencarian $syaratPencarian) : int {
        $query = $this->buildQueryPencarian($syaratPencarian);
        $hasil = $query->get();
        return (int)ceil(((float)count($hasil))/((float)self::JUMLAH_PERHALAMAN));
    }
}

?>