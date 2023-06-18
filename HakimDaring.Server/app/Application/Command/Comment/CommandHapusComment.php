<?php 

declare(strict_types = 1);

namespace App\Application\Command\Comment;

use App\Application\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\IDComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use App\Core\Repository\InformasiUser\Entitas\KelompokUser;
use App\Core\Repository\InformasiUser\InterfaceRepositoryInformasiUser;
use Illuminate\Support\Facades\Auth;

class CommandHapusComment {

    public function __construct(
        private InterfaceRepositoryComment $repositoryComment,
        private InterfaceRepositoryInformasiUser $repositoryInformasiUser
    )
    {
        
    }

    public function execute(RequestHapusComment $request) : void {
        
        $idUser = new IDUser(Auth::id());

        $comment = $this->repositoryComment->commentById(new IDComment(new IDRuanganComment($request->idRuangan), $request->idComment));
        $user = $this->repositoryInformasiUser->byId($idUser);
        if ($comment->ambilIDPenulis() != $idUser && $user->ambilKelompokUser()->ambilKelompok() != KelompokUser::ADMIN) {
            throw new ApplicationException("tidak memiliki hak");
        }

        $comment->ambilStatusComment()->delete();
        $this->repositoryComment->commentUpdate($comment);
    }
}

?>