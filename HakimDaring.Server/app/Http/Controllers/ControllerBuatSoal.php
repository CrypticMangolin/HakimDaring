<?php

namespace App\Http\Controllers;

use App\Core\Repository\Data\DataSoal;
use App\Core\Soal\Data\GagalBuatSoalException;
use App\Core\Soal\Interface\InterfaceBuatSoal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $judul = $request->post("judul");
        $soal = $request->post("soal");
        $batasanWaktuPerTestcase = $request->post("batasan_waktu_per_testcase_dalam_sekon");
        $batasanWaktuSemuaTestcase = $request->post("batasan_waktu_total_semua_testcase_dalam_sekon");
        $batasanMemoriDalamKB = $request->post("batasan_memori_dalam_kb");

        if ($judul == null) {
            return response()->json([
                "error" => "judul bernilai null"
            ], 422);
        }

        if (!is_string($judul)) {
            return response()->json([
                "error" => "judul harus dalam string"
            ], 422);
        }

        if ($soal == null) {
            return response()->json([
                "error" => "soal bernilai null"
            ], 422);
        }

        if (!is_string($soal)) {
            return response()->json([
                "error" => "soal harus dalam string"
            ], 422);
        }

        if ($batasanWaktuPerTestcase == null) {
            return response()->json([
                "error" => "batasanWaktuPerTestcase bernilai null"
            ], 422);
        }
        $batasanWaktuPerTestcase = floatval($batasanWaktuPerTestcase);

        if (!is_double($batasanWaktuPerTestcase)) {
            return response()->json([
                "error" => "batasanWaktuPerTestcase harus dalam float"
            ], 422);
        }

        if ($batasanWaktuSemuaTestcase == null) {
            return response()->json([
                "error" => "batasanWaktuSemuaTestcase bernilai null"
            ], 422);
        }
        $batasanWaktuSemuaTestcase = floatval($batasanWaktuSemuaTestcase);

        if (!is_double($batasanWaktuSemuaTestcase)) {
            return response()->json([
                "error" => "batasanWaktuSemuaTestcase harus dalam float"
            ], 422);
        }

        if ($batasanMemoriDalamKB == null) {
            return response()->json([
                "error" => "batasanMemoriDalamKB bernilai null"
            ], 422);
        }

        if (!is_int($batasanMemoriDalamKB)) {
            return response()->json([
                "error" => "batasanMemoriDalamKB harus dalam integer"
            ], 422);
        }

        try {
            $idSoal = $this->buatSoal->buatSoal(new DataSoal($judul, $soal, $batasanWaktuPerTestcase, $batasanWaktuSemuaTestcase, $batasanMemoriDalamKB));

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
