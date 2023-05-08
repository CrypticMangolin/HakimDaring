<?php
declare(strict_types=1);

namespace App\Core\Autentikasi\Login;

use App\Core\Autentikasi\Login\Data\GagalLoginException;
use App\Core\Autentikasi\Login\InterfaceLogin;
use App\Models\User;
use ErrorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login implements InterfaceLogin {

    public function login(string $email, string $password) : string {
        
        $autentikasi = Auth::attempt(["email" => $email, "password" => $password]);
        if ($autentikasi) {
            $akun_user = Auth::user();
            if ($akun_user instanceof User) {
                $token_autentikasi = $akun_user->createToken("autentikasi")->accessToken;

                return $token_autentikasi;
            }
            throw new ErrorException("Kesalahan pengaturan kelas user");
        }
        throw new GagalLoginException("Data akun salah");
    }
}

?>