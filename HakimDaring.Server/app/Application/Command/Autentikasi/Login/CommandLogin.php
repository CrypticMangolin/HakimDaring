<?php 

declare(strict_types = 1);

namespace App\Application\Command\Autentikasi\Login;

use App\Application\Command\Soal\Exception\ApplicationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommandLogin {

    public function execute(RequestLogin $requestLogin) : string {
        $email = mb_strtolower($requestLogin->email);

        $autentikasi = Auth::attempt(["email" => $email, "password" => $requestLogin->password]);
        if (!$autentikasi) {
            throw new ApplicationException("data akun salah");
        }
        
        $akun_user = Auth::user();
        
        if (!($akun_user instanceof User)) {
            throw new ApplicationException("Kesalahan pengaturan kelas user");
        }

        $token_autentikasi = $akun_user->createToken("autentikasi")->accessToken;
        return $token_autentikasi;
    }
}

?>