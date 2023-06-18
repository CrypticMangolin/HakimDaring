<?php

use App\Http\Controllers\ControllerAutentikasi;
use App\Http\Controllers\ControllerComment;
use App\Http\Controllers\ControllerPencarianSoal;
use App\Http\Controllers\ControllerPengerjaan;
use App\Http\Controllers\ControllerProfile;
use App\Http\Controllers\ControllerSoal;
use App\Http\Controllers\ControllerTestcase;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group([""])
Route::middleware("guest:api")->group(function() {
    Route::post("/autentikasi/login", [ControllerAutentikasi::class, "login"])->name("login");
    Route::post("/autentikasi/register", [ControllerAutentikasi::class, "register"])->name("register");
    Route::get("/belum-login", function() {
        return response()->json(['error' => 'Belum Login'], 401);
    })->name("belum login");
});

Route::middleware("auth:api")->group(function() {
    Route::post("/autentikasi/login-token", [ControllerAutentikasi::class, "cekToken"])->name("cek token");
    Route::post("/autentikasi/logout", [ControllerAutentikasi::class, "logout"])->name("logout");
    
    Route::post("/soal/buat", [ControllerSoal::class, "buatSoal"])->name("buat soal");
    Route::post("/soal/edit", [ControllerSoal::class, "editSoal"])->name("ubah soal");
    Route::get("/soal/informasi/private", [ControllerSoal::class, "ambilDataSoal"])->name("informasi soal private");

    Route::post("/comment/tambah", [ControllerComment::class, "tambahComment"])->name("tambah comment");
    Route::delete("/comment/hapus", [ControllerComment::class, "hapusComment"])->name("hapus comment");

    Route::post("/program/uji", [ControllerPengerjaan::class, "ujiCoba"])->name("uji coba program");
    Route::post("/program/submit", [ControllerPengerjaan::class, "submit"])->name("submit program");
    Route::get("/pengerjaan/soal", [ControllerPengerjaan::class, "ambilDaftarPengerjaan"])->name("daftar pengerjaan");
    Route::get("/pengerjaan/hasil", [ControllerPengerjaan::class, "ambilHasilPengerjaan"])->name("hasil pengerjaan");

    Route::post("/profile", [ControllerProfile::class, "profile"])->name("profile");
}); 

Route::get("/soal/informasi/publik", [ControllerSoal::class, "ambilInformasiSoal"])->name("informasi soal publik");

Route::get("/testcase", [ControllerTestcase::class, "ambilTestcasePublik"])->name("ambil semua testcase");

Route::get("/comment/daftar", [ControllerComment::class, "ambilCommentDariRuangan"])->name("ambil comment");

Route::get("/cari", [ControllerPencarianSoal::class, "cariSoal"])->name("cari soal");
