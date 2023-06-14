<?php 

namespace App\Core\Repository\InformasiUser\Entitas;

use InvalidArgumentException;

class KelompokUser {
    const USER = "user";
    const ADMIN = "admin";

    private string $kelompok;
    
    public function __construct(
        string $kelompok
    )
    {
        if ($kelompok != self::USER && $kelompok != self::ADMIN) {
            throw new InvalidArgumentException("anggota kelompok salah");
        }
        $this->kelompok = $kelompok;
    }

    public function ambilKelompok() : string {
        return $this->kelompok;
    }

    public function isAdmin() : bool {
        return $this->kelompok == self::ADMIN;
    }

    public function isUserBiasa() : bool {
        return $this->kelompok == self::USER;
    }
}

?>