<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\Comment;
use App\Core\Repository\Comment\Entitas\CommentBaru;
use App\Core\Repository\Comment\Entitas\DataComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;

interface InterfaceRepositoryComment {

    /**
     * Untuk membuat ID ruangan comment. Ruangan comment adalah sebuah penanda
     * kumpulan comment. Bila pada twitter semacam thread.
     * 
     * @param IDUser $idPembuat id dari pembuat ruangan comment
     * @return IDRuanganComment id dari ruangan comment yang dibuat
     */
    public function buatRaunganComment(IDUser $idPembuat) : IDRuanganComment;

    /**
     * Untuk menambahkan comment ke dalam sebuah ruangan comment
     * 
     * @param CommentBaru $commentBaru data dari comment yang akan ditambahakn
     */
    public function tambahComment(CommentBaru $commentBaru) : void;


    /**
     * Untuk mengambil seluruh komen yang terdapat di dalam ruangan comment
     * 
     * @param IDRuanganComment $idRuangan id dari ruangan comment
     * @return Comment[] kumpulan comment yang diambil
     */
    public function ambilKumpulanComment(IDRuanganComment $idRuangan) : array;
}

?>