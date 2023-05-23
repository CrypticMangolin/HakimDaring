<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\Comment;
use App\Core\Repository\Comment\Entitas\CommentBaru;
use App\Core\Repository\Comment\Entitas\DataComment;
use App\Core\Repository\Comment\Entitas\IDComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use DateTime;
use Illuminate\Support\Facades\DB;

class RepositoryComment implements InterfaceRepositoryComment {

    public function buatRaunganComment(IDUser $idPembuat) : IDRuanganComment {
        $dataBaru = [
            "id_pembuat" => $idPembuat->ambilID()
        ];

        $id = DB::table("ruangan_comment")->insertGetId($dataBaru);
        return new IDRuanganComment($id);
    }

    public function tambahComment(CommentBaru $dataComment) : void {

        $dataBaru = [
            "id_ruangan" => $dataComment->ambilIDRuangan()->ambilID(),
            "id_penulis" => $dataComment->ambilIDPenulis()->ambilID(),
            "pesan" => $dataComment->ambilPesan(),
            "tanggal_penulisan" => $dataComment->ambilTanggalPenulisan()->format("Y-m-d H:i:s"),
            "status" => $dataComment->ambilStatus()
        ];

        if ($dataComment->ambilReply() != null) {
            $dataBaru["reply"] = $dataComment->ambilReply()->ambilID();
        }

        DB::table("comment")->insert($dataBaru);
    }

    public function ambilKumpulanComment(IDRuanganComment $idRuangan) : array {
        $scriptQuery = "SELECT c.id, c.id_ruangan, u.nama as nama_penulis, c.pesan, c.tanggal_penulisan, c.reply, c.status 
            FROM comment AS c INNER JOIN user AS u ON c.id_penulis = u.id_user WHERE c.id_ruangan = :id_ruangan_comment ORDER BY c.tanggal_penulisan"
        ;

        $hasilQuery = DB::select($scriptQuery, [
            "id_ruangan_comment" => $idRuangan->ambilID()
        ]);

        $daftarComment = [];
        foreach($hasilQuery as $comment) {
            array_push($daftarComment, new Comment(
                new IDComment($comment->id),
                new DataComment(
                    new IDRuanganComment($comment->id_ruangan),
                    $comment->nama_penulis,
                    $comment->pesan,
                    DateTime::createFromFormat("Y-m-d H:i:s", $comment->tanggal_penulisan),
                    $comment->reply == null ? null : new IDComment($comment->reply),
                    $comment->status
                )
            ));
        }

        return $daftarComment;
    }
}

?>