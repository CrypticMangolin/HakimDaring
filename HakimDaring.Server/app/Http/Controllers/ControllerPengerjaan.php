<?php

namespace App\Http\Controllers;

use App\Application\Command\Pengerjaan\SubmitPengerjaan\CommandSubmitPengerjaan;
use App\Application\Command\Pengerjaan\SubmitPengerjaan\RequestSubmitPengerjaan;
use App\Application\Command\Pengerjaan\UjiCobaProgram\CommandUjiCobaProgram;
use App\Application\Command\Pengerjaan\UjiCobaProgram\RequestUjiCobaProgram;
use App\Application\Query\Pengerjaan\InterfaceQueryPengerjaan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerPengerjaan extends Controller
{
    public function submit(Request $request, CommandSubmitPengerjaan $command) : JsonResponse
    {

        $jsonRequest = $request->json()->all();

        if (!array_key_exists("id_soal", $jsonRequest)) {
            return response()->json([
                "error" => "id_soal null"
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

        try {
            $idPengerjaan = $command->execute(new RequestSubmitPengerjaan(
                $jsonRequest["id_soal"],
                $jsonRequest["source_code"],
                $jsonRequest["bahasa"]
            ));

            return response()->json([
                "id_pengerjaan" => $idPengerjaan->ambilID()
            ], 200);
        }
        catch(Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 422);
        }
    }

    public function ujiCoba(Request $request, CommandUjiCobaProgram $command) : JsonResponse
    {
        $jsonRequest = $request->json()->all();

        if (!array_key_exists("id_soal", $jsonRequest)) {
            return response()->json([
                "error" => "id_soal tidak ada"
            ], 422);
        }
        if (!array_key_exists("source_code", $jsonRequest)) {
            return response()->json([
                "error" => "source_code tidak ada"
            ], 422);
        }
        if (!array_key_exists("bahasa", $jsonRequest)) {
            return response()->json([
                "error" => "bahasa tidak ada"
            ], 422);
        }
        if (!is_array($jsonRequest["stdin"])) {
            return response()->json([
                "error" => "stdin harus array string",
            ], 422);
        }

        try {
            $daftarHasilSubmission = $command->execute(new RequestUjiCobaProgram(
                $jsonRequest["id_soal"],
                $jsonRequest["source_code"],
                $jsonRequest["bahasa"],
                $jsonRequest["stdin"]
            ));
    
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
        catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
    }

    public function ambilDaftarPengerjaan(Request $request, InterfaceQueryPengerjaan $queryPengerjaan) : JsonResponse
    {
        $idSoal = $request->input("id_soal");
        if ($idSoal == null) {
            return response()->json([
                "error" => "id_soal null"
            ], 422);
        }
        $idUser = Auth::id();

        $dataPengerjaan = $queryPengerjaan->byPengsubmitDanSoal($idUser, $idSoal);
        if ($dataPengerjaan == null) {
            return response()->json([
                "error" => "pengerjaan tidak ada"
            ], 422);
        }

        $response = [];
        foreach($dataPengerjaan as $pengerjaan) {
            array_push($respon, [
                "id_pengerjaan" => $pengerjaan->idPengerjaan,
                "id_soal" => $pengerjaan->idSoal,
                "judul_soal" => $pengerjaan->namaSoal,
                "bahasa" => $pengerjaan->bahasa,
                "hasil" => $pengerjaan->hasil,
                "total_waktu" => $pengerjaan->totalWaktu,
                "total_memori" => $pengerjaan->totalMemori,
                "tanggal_submit" => $pengerjaan->tanggalSubmit,
                "outdated" => $pengerjaan->outdated,
            ]);
        }
        
        return response()->json($response, 200);
    }

    public function ambilHasilPengerjaan(Request $request, InterfaceQueryPengerjaan $queryPengerjaan) : JsonResponse
    {
        $idPengerjaan = $request->input("id_pengerjaan");
        if ($idPengerjaan == null) {
            return response()->json([
                "error" => "id_pengerjaan null"
            ], 422);
        }

        $dataPengerjaan = $queryPengerjaan->byId($idPengerjaan);
        if ($dataPengerjaan == null) {
            return response()->json([
                "error" => "pengerjaan tidak ada"
            ], 422);
        }

        $daftarHasilTestcase = $queryPengerjaan->ambilHasilTestcase($idPengerjaan);
        $responHasilTestcase = [];

        foreach($daftarHasilTestcase as $hasilTestcase) {
            array_push($responHasilTestcase, [
                "status" => $hasilTestcase->status,
                "waktu" => $hasilTestcase->waktu,
                "memori" => $hasilTestcase->memori
            ]);
        }

        if (Auth::id() != $dataPengerjaan->idPengsubmit) {
            $dataPengerjaan->sourceCode = null;
        }

        $response = [
            "id_pengerjaan" => $dataPengerjaan->idPengerjaan,
            "id_user" => $dataPengerjaan->idPengsubmit,
            "nama_user" => $dataPengerjaan->namaPengsubmit,
            "id_soal" => $dataPengerjaan->idSoal,
            "judul_soal" => $dataPengerjaan->namaSoal,
            "source_code" => $dataPengerjaan->sourceCode,
            "bahasa" => $dataPengerjaan->bahasa,
            "hasil" => $dataPengerjaan->hasil,
            "total_waktu" => $dataPengerjaan->totalWaktu,
            "total_memori" => $dataPengerjaan->totalMemori,
            "tanggal_submit" => $dataPengerjaan->tanggalSubmit,
            "outdated" => $dataPengerjaan->outdated,
            "hasil_testcase" => $responHasilTestcase
        ];
        
        return response()->json($response, 200);
    }
}
