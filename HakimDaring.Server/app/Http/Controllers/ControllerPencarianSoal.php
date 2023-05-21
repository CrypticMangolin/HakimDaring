<?php

namespace App\Http\Controllers;

use App\Core\Pencarian\Exception\HalamanMelewatiBatasException;
use App\Core\Pencarian\Interface\InterfaceCariSoal;
use App\Core\Repository\DaftarSoal\Entitas\KategoriPencarian;
use App\Core\Repository\DaftarSoal\Entitas\SortBy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ControllerPencarianSoal extends Controller
{
    private InterfaceCariSoal $cariSoal;
    private array $mapper = [
        "id_soal" => SortBy::SORTBY_ID,
        "judul" => SortBy::SORTBY_JUDUL,
        "jumlah_submit" => SortBy::SORTBY_JUMLAH_SUBMIT,
        "jumlah_berhasil" => SortBy::SORTBY_JUMLAH_BERHASIL,
        "persentase_berhasil" => SortBy::SORTBY_PERSENTASE_BERHASIL
    ];

    public function __construct(InterfaceCariSoal $cariSoal) {
        if ($cariSoal == null) {
            throw new InvalidArgumentException("cariSoal bernilai null");
        }
        $this->cariSoal = $cariSoal;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $halaman = $request->post("halaman");
        if ($halaman == null) {
            return response()->json([
                "error" => "halaman bernilai null"
            ], 422);
        }

        $judul = $request->post("judul");
        if ($judul == null) {
            $judul = "";
        }

        $sortBy = $request->post("sort_by");
        if ($sortBy == null) {
            return response()->json([
                "error" => "sort_by bernilai null"
            ], 422);
        }

        if (!is_array($sortBy)) {
            return response()->json([
                "error" => "sort_by salah"
            ], 422);
        }

        try {
            $hasilPencarian = $this->cariSoal->cariSoal($halaman, new KategoriPencarian($judul, new SortBy($this->mapper[$sortBy["by"]], $sortBy["reverse"])));

            $hasilPencarianSoal = [];
            foreach($hasilPencarian->ambilHasilPencarian() as $hasil) {
                array_push($hasilPencarianSoal, [
                    "id" => $hasil->ambilIDSoal()->ambilID(),
                    "judul" => $hasil->ambilJudul(),
                    "jumlah_submit" => $hasil->ambilJumlahSubmit(),
                    "jumlah_berhasil" => $hasil->ambilBerhasilSubmit(),
                    "persentase_berhasil" => $hasil->ambilPersentaseBerhasil()
                ]);
            }

            return response()->json([
                "halaman" => $hasilPencarian->ambilHalaman(),
                "total_halaman" => $hasilPencarian->ambilTotalHalaman(),
                "hasil_pencarian" => $hasilPencarianSoal
            ], 200);
        }
        catch(HalamanMelewatiBatasException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }

        
        return response()->json([
            "error" => "Kesalahan internal server"
        ], 500);
    }
}
