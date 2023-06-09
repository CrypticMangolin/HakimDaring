<?php

namespace App\Http\Controllers;

use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Testcase\InterfaceRepositoryTestcase;
use App\Core\Soal\Interfaces\InterfaceAmbilTestcasePublik;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ControllerAmbilTestcasePublik extends Controller
{

    public function __construct(
        private InterfaceAmbilTestcasePublik $ambilTestcasePublik
    ) {}

    public function __invoke(Request $request) : JsonResponse 
    {
        $idSoal = $request->input("id_soal");
        if ($idSoal == null) {
            return response()->json([
                "error" => "id_soal bernilai null"
            ], 422);
        }
        
        $daftarTestcase = $this->ambilTestcasePublik->ambilDaftarTestcase(new IDSoal($idSoal));
        $hasil = [];
        foreach($daftarTestcase as $testcase) {
            array_push($hasil, [
                "testcase" => $testcase->ambilTestcase()->ambilTestcase(),
                "jawaban" => $testcase->ambilTestcase()->ambilJawaban(),
                "urutan" => $testcase->ambilUrutan()
            ]);
        }

        return response()->json($hasil, 200);
    }
}
