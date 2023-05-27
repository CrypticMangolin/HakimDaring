<?php

namespace App\Http\Controllers;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Soal\Exception\TidakMemilikiHakException;
use App\Core\Soal\Interface\InterfaceAmbilDaftarSemuaTestcaseSoal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class ControllerAmbilSemuaTestcase extends Controller
{
    private InterfaceAmbilDaftarSemuaTestcaseSoal $ambilDaftarSemuaTestcaseSoal;

    public function __construct(InterfaceAmbilDaftarSemuaTestcaseSoal $ambilDaftarSemuaTestcaseSoal)
    {
        if ($ambilDaftarSemuaTestcaseSoal == null) {
            throw new InvalidArgumentException("ambilDaftarSemuaTestcaseSoal bernilai null");
        }

        $this->ambilDaftarSemuaTestcaseSoal = $ambilDaftarSemuaTestcaseSoal;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $idSoal = $request->input("id_soal");
        if ($idSoal == null) {
            return response()->json([
                "error" => "id_soal bernilai null"
            ], 422);
        }
        $idSoal = filter_var($idSoal, FILTER_VALIDATE_INT);

        try {
            $daftarTestcase = $this->ambilDaftarSemuaTestcaseSoal->ambilDaftarTestcase(new IDUser(Auth::id()), new IDSoal($idSoal));
            $hasil = [];
            foreach($daftarTestcase as $testcase) {
                array_push($hasil, [
                    "testcase" => $testcase->ambilTestcase()->ambilTestcase(),
                    "jawaban" => $testcase->ambilTestcase()->ambilJawaban(),
                    "urutan" => $testcase->ambilUrutan(),
                    "publik" => $testcase->apakahSoalPublik()
                ]);
            }

            return response()->json($hasil, 200);
        }
        catch(TidakMemilikiHakException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 401);
        }

        return response()->json([
            "error" => "Kesalahan internal server"
        ], 500);
    }
}
