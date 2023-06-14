<?php 

namespace App\Core\Repository\InformasiUser\Entitas;

use App\Core\Repository\Exception\MelebihiUkuranMaksimalException;
use Carbon\Exceptions\InvalidFormatException;

class NamaUser {

    private string $namaUser;

    public function __construct(string $namaUser)
    {
        $this->namaUser = $namaUser;
    }

    public function ambilNama() : string {
        return $this->namaUser;
    }

    public static function buatNamaUser(string $namaUser) : NamaUser {

        if (strlen($namaUser) > 64) {
            throw new MelebihiUkuranMaksimalException("panjang nama maksimal 64 byte");
        }

        if (!preg_match("/^[a-zA-Z0-9_ ]*$/",$namaUser)) {
            throw new InvalidFormatException("format nama hanya boleh huruf, angka, dan underscore");
        }

        return new NamaUser($namaUser);
    }
}

?>