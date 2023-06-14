<?php 

declare(strict_types=1);

namespace App\Infrastructure\Repository\MySQL;

use App\Core\Repository\Autentikasi\Entitas\Akun;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Autentikasi\InterfaceRepositoryAutentikasi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RepositoryAutentikasiMySQL implements InterfaceRepositoryAutentikasi {

    
    public function buatAkun(Akun $akun) : IDUser {
        $hasilQuery = User::query()->create([
            "email" => $akun->ambilEmail()->ambilEmail(),
            "password" => Hash::make($akun->ambilPassword())
        ]);

        $hasilQuery->save();
        return new IDUser($hasilQuery->id);
    }
}

?>