<?php

namespace App\Http\Controllers;

use App\Application\Command\Soal\BuatSoal\CommandBuatSoal;
use App\Application\Command\Soal\BuatSoal\RequestBuatSoal;
use App\Application\Command\Soal\EditSoal\CommandEditSoal;
use App\Application\Command\Soal\EditSoal\RequestEditSoal;
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

class ControllerSoal extends Controller
{
    public function __construct()
    {
        
    }

    public function buatSoal(Request $request, CommandBuatSoal $command) : JsonResponse {
        $jsonRequest = $request->json()->all();

        if (!array_key_exists("judul", $jsonRequest)) {
            return response()->json([
                "error" => "judul null"
            ], 422);
        }
        if (!array_key_exists("soal", $jsonRequest)) {
            return response()->json([
                "error" => "soal null"
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
        if (!array_key_exists("waktu_per_testcase", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanWaktuPerTestcase bernilai null"
            ], 422);
        }
        if (!array_key_exists("waktu_total", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanWaktuSemuaTestcase bernilai null"
            ], 422);
        }
        if (!array_key_exists("memori", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanMemoriDalamKB bernilai null"
            ], 422);
        }

        try {
            $idSoal = $command->execute(new RequestBuatSoal(
                $jsonRequest["judul"],
                $jsonRequest["soal"],
                doubleval($jsonRequest["batasan"]["waktu_per_testcase"]),
                doubleval($jsonRequest["batasan"]["waktu_total"]),
                intval($jsonRequest["batasan"]["memori"]),
                $jsonRequest["daftar_testcase"]
            ));
            return response()->json([
                "id_soal" => $idSoal->ambilID()
            ], 200);
        }
        catch(Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
    }

    public function editSoal(Request $request, CommandEditSoal $command) : JsonResponse
    {
        $jsonRequest = $request->json()->all();

        if (!array_key_exists("id_soal", $jsonRequest)) {
            return response()->json([
                "error" => "id_soal null"
            ], 422);
        }
        if (!array_key_exists("judul", $jsonRequest)) {
            return response()->json([
                "error" => "judul null"
            ], 422);
        }
        if (!array_key_exists("soal", $jsonRequest)) {
            return response()->json([
                "error" => "soal null"
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
        if (!array_key_exists("waktu_per_testcase", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanWaktuPerTestcase bernilai null"
            ], 422);
        }
        if (!array_key_exists("waktu_total", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanWaktuSemuaTestcase bernilai null"
            ], 422);
        }
        if (!array_key_exists("memori", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "batasanMemoriDalamKB bernilai null"
            ], 422);
        }

        try {
            $command->execute(new RequestEditSoal(
                $jsonRequest["id_soal"],
                $jsonRequest["judul"],
                $jsonRequest["soal"],
                doubleval($jsonRequest["batasan"]["waktu_per_testcase"]),
                doubleval($jsonRequest["batasan"]["waktu_total"]),
                intval($jsonRequest["batasan"]["memori"]),
                $jsonRequest["daftar_testcase"]
            ));
        }
        catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
    }
}
