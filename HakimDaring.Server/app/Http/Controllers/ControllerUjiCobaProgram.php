<?php

namespace App\Http\Controllers;

use App\Core\Pengerjaan\Data\BahasaPemrograman;
use App\Core\Pengerjaan\Data\UjiCobaSourceCode;
use App\Core\Pengerjaan\Exception\GagalMenjalankanProgramException;
use App\Core\Pengerjaan\Interfaces\InterfaceUjiCobaProgram;
use App\Core\Repository\Soal\Entitas\IDSoal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ControllerUjiCobaProgram extends Controller
{
    public function __construct(
        private InterfaceUjiCobaProgram $ujiCobaProgram
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

        if (!is_array($jsonRequest["stdin"])) {
            return response()->json([
                "error" => "stdin harus array string",
            ], 422);
        }

        $sourceCode = strval($jsonRequest["source_code"]);

        if (!array_key_exists($jsonRequest["bahasa"], BahasaPemrograman::MAPPING)) {
            return response()->json([
                "error" => "bahasa tidak ditemukan",
            ], 422);
        }

        $idSoal = intval($jsonRequest["id_soal"]);
        $bahasa = BahasaPemrograman::MAPPING[$jsonRequest["bahasa"]];
        $daftarInput = $jsonRequest["stdin"];
        $daftarInputString = [];

        foreach($daftarInput as $input) {
            array_push($daftarInputString, strval($input));
        }

        try {
            $daftarHasilSubmission = $this->ujiCobaProgram->ujiCobaJalankanProgram(
                new IDSoal($idSoal),
                new UjiCobaSourceCode(
                    $sourceCode,
                    $bahasa,
                    $daftarInputString
                )
            );
    
            $respon = [];
            foreach($daftarHasilSubmission as $hasilSubmission) {
                array_push($respon, [
                    "token" => $hasilSubmission->ambilToken()->ambilToken(),
                    "stdout" => $hasilSubmission->ambilHasilKeluaran(),
                    "waktu" => $hasilSubmission->ambilWaktu(),
                    "memori" => $hasilSubmission->ambilMemori(),
                    "error" => $hasilSubmission->ambilError(),
                    "status" => $hasilSubmission->ambilStatus()
                ]);
            }
    
            return response()->json($respon, 200);
        }
        catch (GagalMenjalankanProgramException $e) {
    
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
    }
}
