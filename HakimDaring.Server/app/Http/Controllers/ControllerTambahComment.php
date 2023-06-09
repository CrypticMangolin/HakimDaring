<?php

namespace App\Http\Controllers;

use App\Core\Comment\Exception\GagalMembuatKomentarException;
use App\Core\Comment\Interfaces\InterfaceTambahComment;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Comment\Entitas\IDComment;
use App\Core\Repository\Comment\Entitas\IDRuanganComment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerTambahComment extends Controller
{
    public function __construct(
        private InterfaceTambahComment $tambahComment
    ) {}

    public function __invoke(Request $request) : JsonResponse {
        
        $idPenulis = Auth::id();
        $idRuangan = $request->post("id_ruangan_comment");
        $pesan = $request->post("pesan");
        $reply = $request->post("reply");

        if ($idRuangan == null) {
            return response()->json([
                "error" => "idRuangan bernilai null"
            ], 422);
        }

        if ($pesan == null) {
            return response()->json([
                "error" => "pesan bernilai null"
            ], 422);
        }

        
        try {
            $this->tambahComment->tambahComment(
                new IDRuanganComment($idRuangan), 
                new IDUser($idPenulis),
                $pesan,
                $reply == null ? null : new IDComment($reply)
            );

            return response()->json([
                "success" => "OK"                
            ], 200);
        }
        catch (GagalMembuatKomentarException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
        catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
