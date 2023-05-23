<?php

namespace App\Http\Controllers;

use App\Core\Repository\Comment\Entitas\Comment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use App\Core\Repository\Comment\InterfaceRepositoryComment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ControllerAmbilComment extends Controller
{
    public function __construct(
        private InterfaceRepositoryComment $repositoryComment
    ) {
        
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $idRuanganComment = $request->input("id_ruangan_comment");
        if ($idRuanganComment == null) {
            return response()->json([
                "error" => "id_ruangan_comment bernilai null"
            ], 422);
        }
        $idRuanganComment = filter_var($idRuanganComment, FILTER_VALIDATE_INT);

        try {
            $kumpulanComment = $this->repositoryComment->ambilKumpulanComment(new IDRuanganComment($idRuanganComment));

            $jawaban = [];
            foreach($kumpulanComment as $comment) {
                if ($comment instanceof Comment) {
                    $dataComment = [
                        "id" => $comment->ambilID()->ambilID(),
                        "nama_penulis" => $comment->ambilDataComment()->ambilNamaPenulis(),
                        "pesan" => $comment->ambilDataComment()->ambilPesan(),
                        "tanggal_penulisan" => $comment->ambilDataComment()->ambilTanggalPenulisan()->format('Y-m-d H:i:s'),
                    ];
                    if ($comment->ambilDataComment()->ambilReply() != null) {
                        $dataComment["reply"] = $comment->ambilDataComment()->ambilReply()->ambilID();
                    }
                    array_push($jawaban, $dataComment);
                }
            }
            return response()->json($jawaban);
        }
        catch(Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
