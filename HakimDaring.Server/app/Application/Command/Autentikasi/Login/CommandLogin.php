<?php 

declare(strict_types = 1);

namespace App\Application\Command\Autentikasi\Login;

use App\Application\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Autentikasi\Entitas\InformasiLogin;
use App\Core\Repository\InformasiUser\InterfaceRepositoryInformasiUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommandLogin {

    public function __construct(
        private InterfaceRepositoryInformasiUser $repositoryInformasiUser
    )
    {
        
    }

    public function execute(RequestLogin $requestLogin) : InformasiLogin {
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
        $informasiUser = $this->repositoryInformasiUser->byId(new IDUser(Auth::id()));

        session(['role' => $informasiUser->ambilKelompokUser()->ambilKelompok()]);

        return new InformasiLogin($token_autentikasi, $informasiUser->ambilNamaUser()->ambilNama(), $informasiUser->ambilIDUser());
    }
}

?>