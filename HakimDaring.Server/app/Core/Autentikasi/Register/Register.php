<?php 

declare(strict_types=1);

namespace App\Core\Autentikasi\Register;

use App\Core\Autentikasi\Register\Exception\GagalRegisterException;
use App\Core\Autentikasi\Register\Interface\InterfaceRegister;
use App\Core\Repository\Autentikasi\InterfaceRepositoryAutentikasi;
use InvalidArgumentException;

class Register implements InterfaceRegister {

    private InterfaceRepositoryAutentikasi $repositoryUser;

    public function __construct(InterfaceRepositoryAutentikasi $repositoryUser)
    {
        if ($repositoryUser == null) {
            throw new InvalidArgumentException("repositoryUser Null");
        }

        $this->repositoryUser = $repositoryUser;
    }

    public function register(string $nama, string $email, string $password, string $ulangiPassword) : bool 
    {
        $email = mb_strtolower($email);
        
        if (!$this->repositoryUser->cekEmailBelumDipakai($email)) {
            throw new GagalRegisterException("Email telah dipakai");
        }

        if ($password != $ulangiPassword) {
            throw new GagalRegisterException("Password salah");
        }
        
        return $this->repositoryUser->buatAkun($nama, $email, $password);
    }
}

?>