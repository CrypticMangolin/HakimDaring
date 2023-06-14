<?php

namespace App\Http\Controllers;

use App\Application\Query\Soal\InterfaceQuerySoal;
use App\Application\Query\Testcase\InterfaceQueryTestcase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerTestcase extends Controller
{

    public function ambilTestcasePublik(Request $request, InterfaceQueryTestcase $query) : JsonResponse 
    {
        $idSoal = $request->input("id_soal");
        if ($idSoal == null) {
            return response()->json([
                "error" => "id_soal bernilai null"
            ], 422);
        }
        
        $daftarTestcasePublik = $query->ambilTestcasePublik($idSoal);
        $respon = [];
        foreach($daftarTestcasePublik as $testcase) {
            array_push($respon, [
                "testcase" => $testcase->stdin,
                "jawaban" => $testcase->stdout,
                "publik" => $testcase->publik,
                "urutan" => $testcase->urutan
            ]);
        }

        return response()->json($respon, 200);
    }
}
