<?php

namespace App\Http\Controllers;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\TestcaseData;
use App\Core\Soal\Data\TestcaseDuplikatException;
use App\Core\Soal\Data\TidakMemilikiHakException;
use App\Core\Soal\Interface\InterfaceSetTestcaseSoal;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class ControllerSetTestcaseSoal extends Controller
{
    private InterfaceSetTestcaseSoal $setTestcaseSoal;

    public function __construct(InterfaceSetTestcaseSoal $setTestcaseSoal)
    {
        if ($setTestcaseSoal == null) {
            throw new InvalidArgumentException("setTestcaseSoal bernilai null");
        }

        $this->setTestcaseSoal = $setTestcaseSoal;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $jsonRequest = $request->json()->all();

        if (!array_key_exists("id_soal", $jsonRequest)) {
            return response()->json([
                "error" => "id_soal null"
            ], 422);
        }

        if (!array_key_exists("daftar_testcase", $jsonRequest)) {
            return response()->json([
                "error" => "daftar_testcase null"
            ], 422);
        }

        if (!is_array($jsonRequest["daftar_testcase"]) || count($jsonRequest["daftar_testcase"]) == 0) {
            return response()->json([
                "error" => "daftar_testcase kosong",
            ], 422);
        }

        $idSoal = $jsonRequest["id_soal"];
        $daftarTestcase = $jsonRequest["daftar_testcase"];
        
        $kumpulanTestcaseData = [];
        foreach($daftarTestcase as $testcaseData) {
            try {
                array_push($kumpulanTestcaseData, new TestcaseData(
                    $testcaseData["testcase"],
                    $testcaseData["jawaban"],
                    $testcaseData["urutan"],
                    $testcaseData["publik"]
                ));
            }
            catch(Exception $e) {
                return response()->json([
                    "error" => "Kesalahan data testcase yang dikirimkan"
                ], 422);
            }
        }

        try {
            $this->setTestcaseSoal->setTestcase(new IDUser(Auth::id()), new IDSoal($idSoal), $kumpulanTestcaseData);
        }
        catch(TidakMemilikiHakException $e) {
            return response()->json([
                "error" => "Tidak memiliki hak untuk mengatur testcase"
            ], 422);
        }
        catch(TestcaseDuplikatException $e) {
            return response()->json([
                "error" => "Terdapat testcase yang duplikat"
            ], 422);
        }

        return response()->json([
            "success" => "Berhasil mengatur testcase"
        ], 200);
    }
}
