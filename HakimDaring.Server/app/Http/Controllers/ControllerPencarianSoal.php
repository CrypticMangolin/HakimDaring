<?php

namespace App\Http\Controllers;

use App\Application\Query\Pencarian\InterfaceQueryPencarian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ControllerPencarianSoal extends Controller
{

    public function cariSoal(Request $request, InterfaceQueryPencarian $queryPencarian) : JsonResponse
    {
        $halaman = $request->input("halaman");
        if ($halaman == null) {
            return response()->json([
                "error" => "halaman bernilai null"
            ], 422);
        }
        $halaman = filter_var($halaman, FILTER_VALIDATE_INT);
        if ($halaman < 0) {
            return response()->json([
                "error" => "halaman tidak boleh negatif"
            ], 422);
        }


        $judul = $request->input("judul");
        if ($judul == null) {
            $judul = "";
        }

        $sortBy = $request->input("sort_by");
        if ($sortBy == null) {
            return response()->json([
                "error" => "sort_by bernilai null"
            ], 422);
        }

        $sortReverse = $request->input("sort_reverse");
        if ($sortReverse == null) {
            return response()->json([
                "error" => "sort_reverse bernilai null"
            ], 422);
        }
        $sortReverse = filter_var($sortReverse, FILTER_VALIDATE_BOOLEAN);
        
        $hasilPencarian = $queryPencarian->cariSoal($halaman, $judul, $sortBy, $sortReverse);
        if ($halaman > $hasilPencarian->totalHalaman) {
            return response()->json([
                "error" => "halaman melebihi batas"
            ], 422);
        }

        $hasilPencarianSoal = [];
        foreach($hasilPencarian->hasilPencarian as $hasil) {
            array_push($hasilPencarianSoal, [
                "id_soal" => $hasil->idSoal,
                "judul" => $hasil->judul,
                "jumlah_submit" => $hasil->jumlahSubmit,
                "jumlah_berhasil" => $hasil->berhasilSubmit,
                "persentase_berhasil" => $hasil->persentaseBerhasil,
            ]);
        }

        return response()->json([
            "halaman" => $hasilPencarian->halaman,
            "total_halaman" => $hasilPencarian->totalHalaman,
            "hasil_pencarian" => $hasilPencarianSoal
        ]);
    }
}
