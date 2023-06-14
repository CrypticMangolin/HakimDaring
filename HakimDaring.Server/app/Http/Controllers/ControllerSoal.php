<?php

namespace App\Http\Controllers;

use App\Application\Command\Soal\BuatSoal\CommandBuatSoal;
use App\Application\Command\Soal\BuatSoal\RequestBuatSoal;
use App\Application\Command\Soal\EditSoal\CommandEditSoal;
use App\Application\Command\Soal\EditSoal\RequestEditSoal;
use App\Application\Query\Soal\InterfaceQuerySoal;
use App\Application\Query\Testcase\InterfaceQueryTestcase;
use App\Core\Repository\Soal\Entitas\StatusSoal;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerSoal extends Controller
{
    public function __construct()
    {
        
    }

    public function buatSoal(Request $request, CommandBuatSoal $command) : JsonResponse {
        $jsonRequest = $request->json()->all();

        if (!array_key_exists("judul", $jsonRequest)) {
            return response()->json([
                "error" => "judul tidak ada"
            ], 422);
        }
        if (!array_key_exists("soal", $jsonRequest)) {
            return response()->json([
                "error" => "soal tidak ada"
            ], 422);
        }
        if (!array_key_exists("daftar_testcase", $jsonRequest)) {
            return response()->json([
                "error" => "daftar_testcase tidak ada"
            ], 422);
        }
        if (!is_array($jsonRequest["daftar_testcase"]) || count($jsonRequest["daftar_testcase"]) == 0) {
            return response()->json([
                "error" => "daftar_testcase kosong",
            ], 422);
        }
        if (!array_key_exists("batasan", $jsonRequest)) {
            return response()->json([
                "error" => "batasan tidak ada",
            ], 422);
        }
        if (!array_key_exists("waktu_per_testcase", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "waktu_per_testcase tidak ada"
            ], 422);
        }
        if (!array_key_exists("waktu_total", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "waktu_total tidak ada"
            ], 422);
        }
        if (!array_key_exists("memori", $jsonRequest["batasan"])) {
            return response()->json([
                "error" => "memori tidak ada"
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

            return response()->json([
                "success" => "OK"
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
    }

    public function ambilInformasiSoal(Request $request, InterfaceQuerySoal $query) : JsonResponse {
        $idSoal = $request->input("id_soal");
        if ($idSoal == null) {
            return response()->json([
                "error" => "id_soal null"
            ], 422);
        }

        $dataSoal = $query->byID($idSoal);

        if ($dataSoal == StatusSoal::DELETED) {
            return response()->json([
                "error" => "soal tidak ada"
            ], 422);
        }

        return response()->json([
            "id_soal" => $dataSoal->idSoal,
            "judul" => $dataSoal->judulSoal,
            "soal" => $dataSoal->isiSoal,
            "batasan" => [
                "waktu_per_testcase" => $dataSoal->batasanWaktuPerTestcase,
                "waktu_total" => $dataSoal->batasanWaktuTotal,
                "memori" => $dataSoal->batasanMemori
            ],
            "jumlah_submit" => $dataSoal->jumlahSubmit,
            "jumlah_berhasil" => $dataSoal->jumlahBerhasil,
            "status" => $dataSoal->status,
            "id_ruangan_diskusi" => $dataSoal->idRuanganDiskusi,
            "id_pembuat" => $dataSoal->idPembuat,
            "nama_pembuat" => $dataSoal->namaPembuat
        ], 200);
    }

    public function ambilDataSoal(Request $request, InterfaceQuerySoal $querySoal, InterfaceQueryTestcase $queryTestcase) : JsonResponse {
        $idSoal = $request->input("id_soal");
        if ($idSoal == null) {
            return response()->json([
                "error" => "id_soal null"
            ], 422);
        }
        
        $dataSoal = $querySoal->byID($idSoal);
        if ($dataSoal == null) {
            return response()->json([
                "error" => "soal tidak ada"
            ], 422);
        }
        if ($dataSoal == StatusSoal::DELETED) {
            return response()->json([
                "error" => "soal tidak ada"
            ], 422);
        }
        if (Auth::id() != $dataSoal->idPembuat) {
            return response()->json([
                "error" => "tidak memiliki hak"
            ], 401);
        }

        $daftarTestcase = $queryTestcase->ambilSemuaTestcase($idSoal);
        $responDaftarTestcase = [];
        foreach($daftarTestcase as $testcase) {
            array_push($responDaftarTestcase, [
                "testcase" => $testcase->stdin,
                "jawaban" => $testcase->stdout,
                "publik" => $testcase->publik,
                "urutan" => $testcase->urutan
            ]);
        }

        return response()->json([
            "id_soal" => $dataSoal->idSoal,
            "judul" => $dataSoal->judulSoal,
            "soal" => $dataSoal->isiSoal,
            "batasan" => [
                "waktu_per_testcase" => $dataSoal->batasanWaktuPerTestcase,
                "waktu_total" => $dataSoal->batasanWaktuTotal,
                "memori" => $dataSoal->batasanMemori
            ],
            "jumlah_submit" => $dataSoal->jumlahSubmit,
            "jumlah_berhasil" => $dataSoal->jumlahBerhasil,
            "status" => $dataSoal->status,
            "id_ruangan_diskusi" => $dataSoal->idRuanganDiskusi,
            "id_pembuat" => $dataSoal->idPembuat,
            "nama_pembuat" => $dataSoal->namaPembuat,
            "daftar_testcase" => $responDaftarTestcase
        ], 200);
    }
}
