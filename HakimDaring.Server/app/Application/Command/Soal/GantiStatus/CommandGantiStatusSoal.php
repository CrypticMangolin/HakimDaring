<?php 

declare(strict_types = 1);

namespace App\Application\Command\Soal\GantiStatus;

use App\Application\Command\Soal\GantiStatus\RequestGantiStatusSoal;
use App\Application\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\InformasiUser\Entitas\KelompokUser;
use App\Core\Repository\InformasiUser\InterfaceRepositoryInformasiUser;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use Illuminate\Support\Facades\Auth;

class CommandGantiStatusSoal {

    public function __construct(
        private InterfaceRepositorySoal $repositorySoal,
        private InterfaceRepositoryTestcase $repositoryTestcase,
        private InterfaceRepositoryInformasiUser $repositoryInformasiUser
    )
    {

    }

    public function execute(RequestGantiStatusSoal $request) : void {

        
        $idSoal = new IDSoal($request->idSoal);    
        $soalYangDiganti = $this->repositorySoal->byId($idSoal);

        if ($soalYangDiganti === null) {
            throw new ApplicationException("Soal tidak ada");
        }

        $idUser = new IDUser(Auth::id());
        $user = $this->repositoryInformasiUser->byId($idUser);
        if ($user->ambilKelompokUser()->ambilKelompok() != KelompokUser::ADMIN) {
            throw new ApplicationException("Tidak memiliki hak");
        }

        if ($request->statusSoal === "suspend") {
            $soalYangDiganti->ambilStatusSoal()->suspend();
        } else if ($request->statusSoal === "publik") {
            $soalYangDiganti->ambilStatusSoal()->resetReport();
        }

        $this->repositorySoal->update($soalYangDiganti);
    }
}

?>