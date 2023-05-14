<?php

namespace App\Http\Controllers;

use App\Core\Repository\Data\IDSoal;
use App\Core\Repository\Data\IDUser;
use App\Core\Repository\Data\Soal;
use App\Core\Soal\Data\GagalBuatSoalException;
use App\Core\Soal\Interface\InterfaceUbahSoal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class ControllerUbahSoal extends Controller
{
    private InterfaceUbahSoal $ubahSoal;

    public function __construct(InterfaceUbahSoal $ubahSoal)
    {
        if ($ubahSoal == null) {
            throw new InvalidArgumentException("ubahSoal bernilai null");
        }

        $this->ubahSoal = $ubahSoal;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $idSoal = $request->post("id_soal"); 
        $judul = $request->post("judul");
        $soal = $request->post("soal");

        if ($idSoal == null) {
            return response()->json([
                "error" => "idSoal bernilai null"
            ], 422);
        }

        if (!is_integer($idSoal)) {
            return response()->json([
                "error" => "idSoal harus dalam integer"
            ], 422);
        }

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

        try {
            $idSoal = $this->ubahSoal->ubahSoal(new IDUser(Auth::id()), new Soal(new IDSoal($idSoal), $judul, $soal));

            return response()->json([
                "success" => "Berhasil mengubah soal"
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
