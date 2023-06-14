<?php

namespace App\Http\Controllers;

use App\Core\Repository\Pengerjaan\Entitas\IDPengerjaan;
use App\Core\Repository\Pengerjaan\InterfaceRepositoryPengerjaan;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerAmbilHasilPengerjaan extends Controller
{
    public function __construct(
        private InterfaceRepositoryPengerjaan $repositoryPengerjaan,
        private InterfaceRepositorySoal $repositorySoal
    )
    {
        
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $idPengerjaan = $request->get("id_pengerjaan");

        if ($idPengerjaan == null) {
            return response()->json([
                "error" => "id_pengerjaan null"
            ], 422);
        }

        $dataPengerjaan = $this->repositoryPengerjaan->ambilPengerjaan(new IDPengerjaan($idPengerjaan));

        if ($dataPengerjaan == null) {
            return response()->json([
                "error" => "pengerjaan tidak ada"
            ], 422);
        }

        $informasiSoal = $this->repositorySoal->ambilInformasiSoal($dataPengerjaan->ambilDataPengerjaan()->ambilIDSoal());

        if ($informasiSoal == null) {
            return response()->json([
                "error" => "soal tidak ada"
            ], 422);
        }

        $daftarPengerjaanTestcase = $this->repositoryPengerjaan->ambilPengerjaanTestcase(new IDPengerjaan($idPengerjaan));
        $hasilTestcase = [];

        foreach($daftarPengerjaanTestcase as $pengerjaanTestcase) {
            array_push($hasilTestcase, [
                "status" => $pengerjaanTestcase->ambilStatus(),
                "memori" => $pengerjaanTestcase->ambilMemori(),
                "waktu" => $pengerjaanTestcase->ambilWaktu()
            ]);
        }

        $response = [
            "id_soal" => $informasiSoal->ambilSoal()->ambilIDSoal()->ambilID(),
            "versi_soal" => $dataPengerjaan->ambilDataPengerjaan()->ambilVersiSoal()->ambilVersi() == $informasiSoal->ambilVersi() ? "Terbaru" : "Tertinggal",
            "judul_soal" => $informasiSoal->ambilSoal()->ambilDataSoal()->ambilJudul(),
            "id_pengerjaan" => $dataPengerjaan->ambilIDPengerjaan()->ambilID(),
            "hasil" => $dataPengerjaan->ambilDataPengerjaan()->ambilHasil(),
            "total_waktu" => $dataPengerjaan->ambilDataPengerjaan()->ambilTotalWaktu(),
            "total_memori" => $dataPengerjaan->ambilDataPengerjaan()->ambilTotalMemori(),
            "tanggal_submit" => $dataPengerjaan->ambilDataPengerjaan()->ambilTanggalSubmit()->format("Y-m-d H:i:s"),
            "hasil_testcase" => $hasilTestcase
        ];

        if (Auth::id() == $dataPengerjaan->ambilDataPengerjaan()->ambilIDPembuat()->ambilID()) {
            $response["source_code"] = $dataPengerjaan->ambilDataPengerjaan()->ambilSourceCode();
        }
        
        return response()->json($response, 200);
    }
}
