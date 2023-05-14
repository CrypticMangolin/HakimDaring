<?php 

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Core\Repository\InterfaceRepositoryAutentikasi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RepositoryAutentikasiEloquent implements InterfaceRepositoryAutentikasi {

    public function buatAkun(string $nama, string $email, string $password) : bool {
        $hasilQuery = User::query()->create([
            "nama" => $nama,
            "email" => $email,
            "password" => Hash::make($password)
        ]);

        return $hasilQuery->save();
    }

    public function cekEmailBelumDipakai(string $email) : bool {
        $totalAkunDitemukan = User::query()->where("email", "=", $email)->count();

        return $totalAkunDitemukan == 0;
    }
}

?>