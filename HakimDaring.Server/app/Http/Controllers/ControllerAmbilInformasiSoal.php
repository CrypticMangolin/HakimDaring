<?php

namespace App\Http\Controllers;

use App\Core\Repository\Soal\Entitas\IDSoal;
use App\Core\Repository\Soal\Entitas\InformasiSoal;
use App\Core\Repository\Soal\InterfaceRepositorySoal;
use App\Core\Soal\Exception\TidakMemilikiHakException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class ControllerAmbilInformasiSoal extends Controller
{
    private InterfaceRepositorySoal $repositorySoal;

    public function __construct(InterfaceRepositorySoal $repositorySoal)
    {
        if ($repositorySoal == null) {
            throw new InvalidArgumentException("repositorySoal bernilai null");
        }

        $this->repositorySoal = $repositorySoal;
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

        if (!is_integer(intval($idSoal))) {
            return response()->json([
                "error" => "id_soal harus integer"
            ], 422);
        }

        try {
            $informasiSoal = $this->repositorySoal->ambilInformasiSoal(new IDSoal(intval($idSoal)));

            if ($informasiSoal == null) {
                return response()->json([
                    "error" => "tidak ada soal"
                ], 422);
            }

            if (!($informasiSoal instanceof InformasiSoal)) {
                return response()->json([
                    "error" => "Kesalahan internal"
                ], 500);
            }

            $idPembuatSoal = $this->repositorySoal->ambilIDPembuatSoal(new IDSoal($idSoal));
            
            $respon = [
                'id_soal' => $informasiSoal->ambilSoal()->ambilIDSoal()->ambilID(),
                'judul' => $informasiSoal->ambilSoal()->ambilDataSoal()->ambilJudul(),
                'soal' => $informasiSoal->ambilSoal()->ambilDataSoal()->ambilSoal(),
                "versi" => $informasiSoal->ambilVersi(),
                'status' => $informasiSoal->ambilStatus(),
                "batasan_waktu_per_testcase_dalam_sekon" => $informasiSoal->ambilBatasanWaktuPerTestcase(),
                "batasan_waktu_total_semua_testcase_dalam_sekon" => $informasiSoal->ambilBatasanWaktuTotal(),
                "batasan_memori_dalam_kb" => $informasiSoal->ambilBatasanMemoriDalamKB(),
                'jumlah_submit' => $informasiSoal->ambilTotalSubmit(),
                'jumlah_berhasil' => $informasiSoal->ambilTotalBerhasil(),
                'id_ruangan_diskusi' => $informasiSoal->ambilIDRuanganDiskusi()->ambilID(),
            ];

            if (Auth::check()) {
                $respon["pembuat"] = Auth::id() === $this->repositorySoal->ambilIDPembuatSoal($informasiSoal->ambilSoal()->ambilIDSoal());
            }

            return response()->json($respon, 200);
        }
        catch (TidakMemilikiHakException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 401);
        }
    }
}
