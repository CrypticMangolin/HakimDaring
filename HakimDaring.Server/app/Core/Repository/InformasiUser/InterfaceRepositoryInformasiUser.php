<?Php 

declare(strict_types = 1);

namespace App\Core\Repository\InformasiUser;

use App\Core\Repository\Autentikasi\Entitas\Email;
use App\Core\Repository\InformasiUser\Entitas\InformasiUser;

interface InterfaceRepositoryInformasiUser {
    
    public function byEmail(Email $email) : ?InformasiUser;
    public function save(InformasiUser $informasiUser) : void;
    public function update(InformasiUser $informasiUser) : void;
}

?>