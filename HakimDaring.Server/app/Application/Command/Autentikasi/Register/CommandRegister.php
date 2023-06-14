<?php 

declare(strict_types = 1);

namespace App\Application\Command\Autentikasi\Register;

use App\Application\Command\Soal\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\Akun;
use App\Core\Repository\Autentikasi\Entitas\Email;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Autentikasi\InterfaceRepositoryAutentikasi;
use App\Core\Repository\InformasiUser\Entitas\InformasiUser;
use App\Core\Repository\InformasiUser\Entitas\KelompokUser;
use App\Core\Repository\InformasiUser\Entitas\NamaUser;
use App\Core\Repository\InformasiUser\InterfaceRepositoryInformasiUser;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;

class CommandRegister {

    public function __construct(
        private InterfaceRepositoryAutentikasi $repositoryAutentikasi,
        private InterfaceRepositoryInformasiUser $repositoryInformasiUser
    )
    {
        
    }

    public function execute(RequestRegister $requestLogin) : void {
        $email = new Email(mb_strtolower($requestLogin->email));

        $akunLainDenganEmailYangSama = $this->repositoryInformasiUser->byEmail($email);

        if ($akunLainDenganEmailYangSama !== null) {
            throw new ApplicationException("akun telah dipakai");
        }

        if ($requestLogin->password != $requestLogin->ulangiPassword) {
            throw new ApplicationException("password salah");
        }

        $idUser = $this->repositoryAutentikasi->buatAkun(new Akun($email, $requestLogin->password));
        $this->repositoryInformasiUser->save(new InformasiUser(
            $idUser,
            new NamaUser($requestLogin->nama),
            $email,
            new KelompokUser(KelompokUser::USER),
            new DateTime("now")
        ));

    }
}

?>