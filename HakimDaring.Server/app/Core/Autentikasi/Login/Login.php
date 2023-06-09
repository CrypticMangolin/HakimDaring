<?php
declare(strict_types=1);

namespace App\Core\Autentikasi\Login;

use App\Core\Autentikasi\Login\Exception\GagalLoginException;
use App\Core\Autentikasi\Login\Interfaces\InterfaceLogin;
use App\Models\User;
use ErrorException;
use Illuminate\Support\Facades\Auth;

class Login implements InterfaceLogin {

    public function login(string $email, string $password) : string {
        
        $email = mb_strtolower($email);

        $autentikasi = Auth::attempt(["email" => $email, "password" => $password]);
        if (!$autentikasi) {
            throw new GagalLoginException("Data akun salah");
        }
        
        $akun_user = Auth::user();
        
        if (!($akun_user instanceof User)) {
            throw new ErrorException("Kesalahan pengaturan kelas user");
        }

        $token_autentikasi = $akun_user->createToken("autentikasi")->accessToken;
        return $token_autentikasi;
    }
}

?>