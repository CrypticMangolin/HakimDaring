<?php

namespace App\Http\Controllers;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Soal\Entitas\BatasanSoal;
use App\Core\Repository\Soal\Entitas\DataSoal;
use App\Core\Repository\Testcase\Entitas\Testcase;
use App\Core\Repository\Testcase\Entitas\TestcaseData;
use App\Core\Soal\Exception\GagalBuatSoalException;
use App\Core\Soal\Interfaces\InterfaceBuatSoal;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class ControllerBuatSoal extends Controller
{
    private InterfaceBuatSoal $buatSoal;

    public function __construct(InterfaceBuatSoal $buatSoal)
    {
        if ($buatSoal == null) {
            throw new InvalidArgumentException("buatSoal bernilai null");
        }

        $this->buatSoal = $buatSoal;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $jsonRequest = $request->json()->all();

        if (!array_key_exists("judul", $jsonRequest)) {
            return response()->json([
                "error" => "judul null"
            ], 422);
        }
        if (!array_key_exists("soal", $jsonRequest)) {
            return response()->json([
                "error" => "judul null"
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

        $judul = $jsonRequest["judul"];
        $soal = $jsonRequest["soal"];
        $daftarTestcase = $jsonRequest["daftar_testcase"];
        $batasanWaktuPerTestcase = floatval($jsonRequest["batasan"]["batasan_waktu_per_testcase_dalam_sekon"]);
        $batasanWaktuSemuaTestcase = floatval($jsonRequest["batasan"]["batasan_waktu_total_semua_testcase_dalam_sekon"]);
        $batasanMemoriDalamKB = intval($jsonRequest["batasan"]["batasan_memori_dalam_kb"]);

        
        $kumpulanTestcaseData = [];
        foreach($daftarTestcase as $testcaseData) {
            try {
                array_push($kumpulanTestcaseData, new TestcaseData(
                    new Testcase(
                        $testcaseData["testcase"],
                        $testcaseData["jawaban"],
                    ),
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
            $idSoal = $this->buatSoal->buatSoal(new IDUser(Auth::id()), new DataSoal($judul, $soal), $batasanBaru, $kumpulanTestcaseData);

            return response()->json([
                "id_soal" => $idSoal->ambilID()
            ], 200);
        }
        catch(GagalBuatSoalException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
        return response()->json([
            "error" => "Kesalahan internal server"
        ], 500);
    }
}
