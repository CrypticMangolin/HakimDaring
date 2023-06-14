<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository\MySQL;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\Comment;
use App\Core\Repository\Comment\Entitas\IDComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Comment\Entitas\IsiComment;
use App\Core\Repository\Comment\Entitas\RuanganComment;
use App\Core\Repository\Comment\Entitas\StatusComment;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use DateTime;
use Illuminate\Support\Facades\DB;

class RepositoryCommentMySQL implements InterfaceRepositoryComment {

    public function ruanganCommentById(IDRuanganComment $idRuanganComment) : ?RuanganComment {
        $script = "SELECT rc.id_ruangan, rc.id_pembuat FROM ruangan_comment AS rc WHERE rc.id_ruangan = :id_ruangan";

        $hasilQuery = DB::select($script, [
            "id_ruangan" => $idRuanganComment->ambilID()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        } 

        $hasil = $hasilQuery[0];
        return new RuanganComment(new IDRuanganComment($hasil->id_ruangan), new IDUser($hasil->id_pembuat));
    }

    public function ruanganCommentSave(RuanganComment $ruanganComment) : void {
        DB::table("ruangan_comment")->insert([
            "id_ruangan" => $ruanganComment->ambilIDRuangan()->ambilID(),
            "id_pembuat" => $ruanganComment->ambilPembuat()->ambilID()
        ]);
    }

    /**
     * @return Comment[]
     */
    public function commentByIdRuangan(IDRuanganComment $idRuanganComment) : array {
        $script = "SELECT c.id_comment, c.id_ruangan, c.id_penulis, c.pesan, c.tanggal_penulisan, c.reply, c.status, c.jumlah_report
            FROM comment AS c WHERE c.id_ruangan = :id_ruangan";
        
        $hasilQuery = DB::select($script, [
            "id_ruangan" => $idRuanganComment->ambilID()
        ]);

        $hasilAkhir = [];

        foreach($hasilQuery as $hasil) {
            array_push($hasilAkhir, new Comment(
                new IDComment($idRuanganComment, $hasil->id_comment), 
                new IDUser($hasil->id_penulis), 
                new IsiComment($hasil->pesan), 
                new DateTime($hasil->tanggal_penulisan), 
                $hasil->reply ? new IDComment($idRuanganComment, $hasil->reply) : null, 
                new StatusComment($hasil->status, $hasil->jumlah_report))
            );
        }

        return $hasilAkhir;

    }
    
    public function commentSave(Comment $comment) : void {
        DB::table("comment")->insert([
            "id_comment" => $comment->ambilID()->ambilID(),
            "id_ruangan" => $comment->ambilID()->ambilIDRuangan(),
            "id_penulis" => $comment->ambilIDPenulis()->ambilID(),
            "pesan" => $comment->ambilIsiComment()->ambilIsiComment(),
            "tanggal_penulisan" => $comment->ambilTanggalPenulisan(),
            "reply" => $comment->ambilReply() ? $comment->ambilReply()->ambilID() : null,
            "status" => $comment->ambilStatusComment()->ambilStatus(),
            "jumlah_report" => $comment->ambilStatusComment()->ambilJumlahReport(),
        ]);
    }

    public function commentUpdate(Comment $comment) : void {
        DB::table("comment")->where("id_comment", "=", $comment->ambilID()->ambilID())->update([
            "id_comment" => $comment->ambilID()->ambilID(),
            "id_ruangan" => $comment->ambilID()->ambilIDRuangan(),
            "id_penulis" => $comment->ambilIDPenulis()->ambilID(),
            "pesan" => $comment->ambilIsiComment()->ambilIsiComment(),
            "tanggal_penulisan" => $comment->ambilTanggalPenulisan(),
            "reply" => $comment->ambilReply() ? $comment->ambilReply()->ambilID() : null,
            "status" => $comment->ambilStatusComment()->ambilStatus(),
            "jumlah_report" => $comment->ambilStatusComment()->ambilJumlahReport(),
        ]);
    }
}

?>