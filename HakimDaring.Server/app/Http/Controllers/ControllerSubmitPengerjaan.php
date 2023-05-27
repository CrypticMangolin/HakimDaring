<?php

namespace App\Http\Controllers;

use App\Core\Pengerjaan\Data\BahasaPemrograman;
use App\Core\Pengerjaan\Data\PengerjaanSourceCode;
use App\Core\Pengerjaan\Exception\GagalSubmitProgramException;
use App\Core\Pengerjaan\Interface\InterfaceSubmitPengerjaanProgram;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerSubmitPengerjaan extends Controller
{
    public function __construct(
        private InterfaceSubmitPengerjaanProgram $submitPengerjaan
    )
    {
        
    }
    public function __invoke(Request $request) : JsonResponse
    {

        $jsonRequest = $request->json()->all();

        if (!array_key_exists("id_soal", $jsonRequest)) {
            return response()->json([
                "error" => "source_code null"
            ], 422);
        }

        if (!array_key_exists("source_code", $jsonRequest)) {
            return response()->json([
                "error" => "source_code null"
            ], 422);
        }

        if (!array_key_exists("bahasa", $jsonRequest)) {
            return response()->json([
                "error" => "bahasa null"
            ], 422);
        }

        
        if (!array_key_exists($jsonRequest["bahasa"], BahasaPemrograman::MAPPING)) {
            return response()->json([
                "error" => "bahasa tidak ditemukan",
            ], 422);
        }
        
        $idSoal = intval($jsonRequest["id_soal"]);
        $sourceCode = strval($jsonRequest["source_code"]);
        $bahasa = BahasaPemrograman::MAPPING[$jsonRequest["bahasa"]];

        try {
            $idPengerjaan = $this->submitPengerjaan->submitProgram(
                new PengerjaanSourceCode(
                    new IDUser(Auth::id()),
                    new IDSoal($idSoal),
                    $sourceCode,
                    $bahasa
                )
            );

            return response()->json([
                "id_pengerjaan" => $idPengerjaan->ambilID()
            ], 200);
        }
        catch(GagalSubmitProgramException $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            "error" => "Kesalahan Internal Server",
        ], 500);
    }
}
