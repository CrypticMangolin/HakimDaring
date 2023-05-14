<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Core\Repository\Data\HasilPencarianSoal;
use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\KategoriPencarian;
use App\Core\Repository\InterfaceRepositoryDaftarSoal;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class RepositoryDaftarSoal implements InterfaceRepositoryDaftarSoal {

    private function buildQueryPencarian(KategoriPencarian $syaratPencarian) : Builder {
        $query = DB::table("soal")->select([
            "id",
            "judul",
            "jumlah_submit",
            "jumlah_berhasil"
        ])->whereRaw("judul LIKE %?%", $syaratPencarian->ambilKataKunciJudul());
        return $query;
    }

    public function ambilDaftarSoalHalaman(int $halaman, KategoriPencarian $syaratPencarian) : array {
        $query = $this->buildQueryPencarian($syaratPencarian);
        
        $hasil = $query->offset(self::JUMLAH_PERHALAMAN * $halaman)->limit(self::JUMLAH_PERHALAMAN)->get();

        $daftarHasilpencarian = [];
        foreach($hasil as $hasilPencarian) {
            array_push($daftarHasilpencarian, new HasilPencarianSoal(
                new IDSoal($hasilPencarian->id),
                $hasilPencarian->judul,
                $hasilPencarian->jumlah_submit,
                $hasilPencarian->jumlah_berhasil,
                $hasilPencarian->jumlah_submit > 0 ? $hasilPencarian->jumlah_berhasil / $hasilPencarian->jumlah_submit : 0
            ));
        }

        return $daftarHasilpencarian;
    }

    public function ambilTotalHalaman(KategoriPencarian $syaratPencarian) : int {
        $query = $this->buildQueryPencarian($syaratPencarian);
        $hasil = $query->get();
        return (int)ceil(count($hasil)/self::JUMLAH_PERHALAMAN);
    }
}

?>