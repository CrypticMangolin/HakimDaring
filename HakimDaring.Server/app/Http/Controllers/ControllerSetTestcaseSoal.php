<?php

namespace App\Http\Controllers;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Testcase\Entitas\TestcaseData;
use App\Core\Soal\Exception\TestcaseDuplikatException;
use App\Core\Soal\Exception\TidakMemilikiHakException;
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

        if (!array_key_exists("batasan", $jsonRequest)) {
            return response()->json([
                "error" => "batasan kosong",
            ], 422);
        }

        if (!array_key_exists("batasan_waktu_per_testcase_dalam_sekon", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanWaktuPerTestcase bernilai null"
            ], 422);
        }

        if (!array_key_exists("batasan_waktu_total_semua_testcase_dalam_sekon", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanWaktuSemuaTestcase bernilai null"
            ], 422);
        }

        if (!array_key_exists("batasan_memori_dalam_kb", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanMemoriDalamKB bernilai null"
            ], 422);
        }

        $idSoal = $jsonRequest["id_soal"];
        $daftarTestcase = $jsonRequest["daftar_testcase"];
        $batasanWaktuPerTestcase = floatval($jsonRequest["batasan"]["batasan_waktu_per_testcase_dalam_sekon"]);
        $batasanWaktuSemuaTestcase = floatval($jsonRequest["batasan"]["batasan_waktu_total_semua_testcase_dalam_sekon"]);
        $batasanMemoriDalamKB = intval($jsonRequest["batasan"]["batasan_memori_dalam_kb"]);

        
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

        $batasanBaru = new BatasanSoal(
            $batasanWaktuPerTestcase,
            $batasanWaktuSemuaTestcase,
            $batasanMemoriDalamKB
        );

        try {
            $this->setTestcaseSoal->setTestcase(new IDUser(Auth::id()), new IDSoal($idSoal), $batasanBaru, $kumpulanTestcaseData);
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
        catch(InvalidArgumentException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }

        return response()->json([
            "success" => "Berhasil mengatur testcase"
        ], 200);
    }
}
