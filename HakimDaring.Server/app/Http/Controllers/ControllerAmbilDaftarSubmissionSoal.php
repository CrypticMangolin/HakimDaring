<?php

namespace App\Http\Controllers;

use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\Pengerjaan\InterfaceRepositoryPengerjaan;
use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerAmbilDaftarSubmissionSoal extends Controller
{
    private InterfaceRepositoryPengerjaan $repositoryPengerjaan;
    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(InterfaceRepositoryPengerjaan $repositoryPengerjaan, InterfaceRepositorySoal $repositorySoal)
    {
        $this->repositoryPengerjaan = $repositoryPengerjaan;
        $this->repositorySoal = $repositorySoal;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $idSoal = $request->get("id_soal");

        if ($idSoal == null) {
            return response()->json([
                "error" => "id_soal null"
            ], 422);
        }

        
        $daftarPengerjaan = $this->repositoryPengerjaan->ambilDaftarPengerjaan(new IDUser(Auth::id()), new IDSoal($idSoal));
        $versiSoal = $this->repositorySoal->ambilVersiSoal(new IDSoal($idSoal));

        $respon = [];
        foreach($daftarPengerjaan as $pengerjaan) {
            array_push($respon, [
                "id_pengerjaan" => $pengerjaan->ambilIDPengerjaan()->ambilID(),
                "bahasa" => $pengerjaan->ambilDataPengerjaan()->ambilBahasa(),
                "hasil" => $pengerjaan->ambilDataPengerjaan()->ambilHasil(),
                "tanggal_submit" => $pengerjaan->ambilDataPengerjaan()->ambilTanggalSubmit()->format("Y-m-d H:i:s"),
                "total_waktu" => $pengerjaan->ambilDataPengerjaan()->ambilTotalWaktu(),
                "total_memori" => $pengerjaan->ambilDataPengerjaan()->ambilTotalMemori(),
                "status" => $versiSoal == $pengerjaan->ambilDataPengerjaan()->ambilVersiSoal() ? "Terbaru" : "Tertinggal"
            ]);
        }

        return response()->json($respon, 200);
    }
}
