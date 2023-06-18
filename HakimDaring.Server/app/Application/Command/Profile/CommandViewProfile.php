<?php 

declare(strict_types = 1);

namespace App\Application\Command\Profile;
use App\Application\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\InformasiUser\Entitas\InformasiUser;
use App\Core\Repository\InformasiUser\InterfaceRepositoryInformasiUser;
use Illuminate\Support\Facades\Auth;

class CommandViewProfile {

    public function __construct(
        public InterfaceRepositoryInformasiUser $repositoryUserInfo
    ) {}

    public function execute() : InformasiUser {
        $iduser = new IDUser(Auth::id());

        $user = $this->repositoryUserInfo->byId($iduser);
        if($user == null) {
            throw new ApplicationException("User tidak ditemukan");
        }

        return $user;
    }
}

?>