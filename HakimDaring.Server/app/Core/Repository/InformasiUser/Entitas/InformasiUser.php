<?php 

namespace App\Core\Repository\InformasiUser\Entitas;

use App\Core\Repository\Autentikasi\Entitas\Email;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use DateTime;

class InformasiUser {

    private IDUser $idUser;
    private NamaUser $namaUser;
    private Email $email;
    private KelompokUser $kelompokUser;
    private DateTime $tanggalBergabung;
    
    public function __construct(
        IDUser $idUser,
        NamaUser $namaUser,
        Email $email,
        KelompokUser $kelompokUser,
        ?DateTime $tanggalBergabung
    )
    {
        $this->idUser = $idUser;
        $this->namaUser = $namaUser;
        $this->email = $email;
        $this->kelompokUser = $kelompokUser;
        $this->tanggalBergabung = $tanggalBergabung ? $tanggalBergabung : new DateTime("now");
    }

    public function ambilIDUser() : IDUser {
        return $this->idUser;
    }

    public function ambilNamaUser() : NamaUser {
        return $this->namaUser;
    }

    public function ambilEmail() : Email {
        return $this->email;
    }

    public function ambilKelompokUser() : KelompokUser {
        return $this->kelompokUser;
    }

    public function ambilTanggalBergabung() : DateTime {
        return $this->tanggalBergabung;
    }
}

?>