<?php 

declare(strict_types = 1);

namespace App\Application\Command\Comment;

use App\Application\Exception\ApplicationException;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\Comment;
use App\Core\Repository\Comment\Entitas\IDComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Comment\Entitas\IsiComment;
use App\Core\Repository\Comment\Entitas\StatusComment;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use DateTime;
use Illuminate\Support\Facades\Auth;

class CommandTambahComment {

    public function __construct(
        private InterfaceRepositoryComment $repositoryComment
    )
    {
        
    }

    public function execute(RequestTambahComment $request) : void {

        $idRuanganComment = new IDRuanganComment($request->idRuangan);
        $ruanganComment = $this->repositoryComment->ruanganCommentById($idRuanganComment);

        if ($ruanganComment === null) {
            throw new ApplicationException("ruangan tidak ada");
        }

        $commentBaru = new Comment(
            new IDComment($idRuanganComment, null),
            new IDUser(Auth::id()),
            IsiComment::buatIsiComment($request->isiComment),
            new DateTime("now"),
            $request->reply ? new IDComment($idRuanganComment, $request->reply) : null,
            new StatusComment(StatusComment::PUBLIK, 0)
        );
        $this->repositoryComment->commentSave($commentBaru);
    }
}

?>