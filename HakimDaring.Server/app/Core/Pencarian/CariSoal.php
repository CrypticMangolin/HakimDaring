<?php 

declare(strict_types = 1);

namespace App\Core\Pencarian;

use App\Core\Pencarian\Data\HalamanMelewatiBatasException;
use App\Core\Pencarian\Interface\InterfaceCariSoal;
use App\Core\Repository\Data\HasilPencarian;
use App\Core\Repository\Data\KategoriPencarian;
use App\Core\Repository\InterfaceRepositoryDaftarSoal;
use InvalidArgumentException;

class CariSoal implements InterfaceCariSoal {

    private InterfaceRepositoryDaftarSoal $repositoryDaftarSoal;

    public function __construct(InterfaceRepositoryDaftarSoal $repositoryDaftarSoal)
    {
        if ($repositoryDaftarSoal == null) {
            throw new InvalidArgumentException("repositoryDaftarSoal bernilai null");
        }

        $this->repositoryDaftarSoal = $repositoryDaftarSoal;
    }

    public function cariSoal(int $halaman, KategoriPencarian $kategoriPencarian) : HasilPencarian {
        $totalHalaman = $this->repositoryDaftarSoal->ambilTotalHalaman($kategoriPencarian);
        if ($halaman > $totalHalaman) {
            throw new HalamanMelewatiBatasException("Total halaman hanya ".$totalHalaman." halaman");
        }

        return new HasilPencarian($halaman, $totalHalaman, 
            $this->repositoryDaftarSoal->ambilDaftarSoalHalaman($halaman, $kategoriPencarian)
        );
    }

}

?>