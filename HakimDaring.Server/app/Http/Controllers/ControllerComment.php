<?php

namespace App\Http\Controllers;

use App\Application\Command\Comment\CommandHapusComment;
use App\Application\Command\Comment\CommandTambahComment;
use App\Application\Command\Comment\RequestHapusComment;
use App\Application\Command\Comment\RequestTambahComment;
use App\Application\Query\Comment\InterfaceQueryComment;
use App\Core\Repository\Comment\Entitas\StatusComment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ControllerComment extends Controller
{

    public function tambahComment(Request $request, CommandTambahComment $command) : JsonResponse {

        $jsonRequest = $request->json()->all();
        if (!array_key_exists("id_ruangan", $jsonRequest)) {
            return response()->json([
                "error" => "id_ruangan tidak ada"
            ], 422);
        }
        if (!array_key_exists("isi", $jsonRequest)) {
            return response()->json([
                "error" => "isi tidak ada"
            ], 422);
        }
        if (!array_key_exists("reply", $jsonRequest)) {
            return response()->json([
                "error" => "reply tidak ada"
            ], 422);
        }

        
        try {
            $command->execute(new RequestTambahComment(
                $jsonRequest["id_ruangan"],
                $jsonRequest["isi"],
                $jsonRequest["reply"]
            ));

            return response()->json([
                "success" => "OK"                
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function hapusComment(Request $request, CommandHapusComment $commandHapusComment) : JsonResponse {
        $idRuanganComment = $request->input("id_ruangan");
        $idComment = $request->input("id_comment");
        if ($idRuanganComment === null) {
            return response()->json([
                "error" => "id_ruangan tidak ada"
            ], 422);
        }
        if ($idComment === null) {
            return response()->json([
                "error" => "id_comment tidak ada"
            ], 422);
        }

        try {
            $commandHapusComment->execute(new RequestHapusComment(
                $idRuanganComment,
                $idComment
            ));
        }
        catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ], 422);
        }

        return response()->json();
    }
    
    public function ambilCommentDariRuangan(Request $request, InterfaceQueryComment $queryComment) {
        $idRuanganComment = $request->input("id_ruangan_comment");
        if ($idRuanganComment == null) {
            return response()->json([
                "error" => "id_ruangan_comment null"
            ], 422);
        }

        $daftarComment = $queryComment->byIDRuanganComment($idRuanganComment);
        
        $hasilAkhir = [];
        foreach($daftarComment as $comment) {
            $isiComment = "[".$comment->status."]";
            if ($comment->status == StatusComment::PUBLIK) {
                $isiComment = $comment->isiPesan;
            }
            array_push($hasilAkhir, [
                "id_comment" => $comment->idComment,
                "id_penulis" => $comment->idPenulis,
                "nama_penulis" => $comment->namaPenulis,
                "isi" => $isiComment,
                "tanggal_penulisan" => $comment->tanggalPenulisan,
                "reply" => $comment->reply,
                "status" => $comment->status
            ]);
        }
        
        return response()->json($hasilAkhir, 200);
    }
}
