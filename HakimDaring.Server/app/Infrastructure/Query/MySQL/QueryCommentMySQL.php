<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Query\MySQL;

use App\Application\Query\Comment\CommentDTO;
use App\Application\Query\Comment\InterfaceQueryComment;
use Illuminate\Support\Facades\DB;

class QueryCommentMySQL implements InterfaceQueryComment {

    public function byIDRuanganComment(string $idRuanganComment) : array {
        $script = "SELECT c.id_comment, c.id_penulis, du.nama_user, c.pesan, c.tanggal_penulisan, c.reply, c.status
            FROM comment AS c INNER JOIN data_user AS du ON c.id_penulis = du.id_user WHERE c.id_ruangan = :id_ruangan
            ORDER BY c.tanggal_penulisan ASC";
        $hasilQuery = DB::select($script, [
            "id_ruangan" => $idRuanganComment
        ]);

        /**
         * @var CommentDTO[] $daftarComment
         */
        $daftarComment = [];
        foreach($hasilQuery as $hasil) {
            array_push($daftarComment, new CommentDTO(
                $hasil->id_comment,
                $hasil->id_penulis,
                $hasil->nama_user,
                $hasil->pesan,
                $hasil->tanggal_penulisan,
                $hasil->reply,
                $hasil->status
            ));
        }

        return $daftarComment;
    }
    
}

?>