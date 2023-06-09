<?php 

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\Soal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Soal\Exception\GagalBuatSoalException;
use App\Core\Soal\Exception\TidakMemilikiHakException;
use App\Core\Soal\Interfaces\InterfacePengecekPembuatSoal;
use App\Core\Soal\Interfaces\InterfaceUbahSoal;
use InvalidArgumentException;

class UbahSoal implements InterfaceUbahSoal {
    
    private const UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE = 255;
    private const UKURAN_MAKSIMAL_SOAL_DALAM_BYTE = 4000000;
    
    private InterfacePengecekPembuatSoal $pengecekPembuatSoal;

    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(
        InterfacePengecekPembuatSoal $pengecekPembuatSoal,
        InterfaceRepositorySoal $repositorySoal
    ) {
        if ($pengecekPembuatSoal == null) {
            throw new InvalidArgumentException("pengecekPembuatSoal bernilai null");
        }

        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal bernilai null");
        }

        $this->pengecekPembuatSoal = $pengecekPembuatSoal;
        $this->repositorySoal = $repositorySoal;
    }

    public function ubahSoal(IDUser $idUser, Soal $soalBaru): void
    {
        if (! $this->pengecekPembuatSoal->cekApakahUserYangMembuatSoal($idUser, $soalBaru->ambilIDSoal())) {
            throw new TidakMemilikiHakException("Tidak memiliki hak untuk mengubah soal");
        }

        if (strlen($soalBaru->ambilDataSoal()->ambilJudul()) > $this::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE) {
            throw new GagalBuatSoalException("Ukuran judul melebihi ".self::UKURAN_MAKSIMAL_JUDUL_DALAM_BYTE." byte");
        }

        if (strlen($soalBaru->ambilDataSoal()->ambilSoal()) > $this::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE) {
            throw new GagalBuatSoalException("Ukuran soal melebihi ".self::UKURAN_MAKSIMAL_SOAL_DALAM_BYTE." byte");
        }
        
        $this->repositorySoal->ubahSoal($soalBaru);
    }
}

?>