<?php

use App\Http\Controllers\ControllerAmbilComment;
use App\Http\Controllers\ControllerAmbilDaftarSubmissionSoal;
use App\Http\Controllers\ControllerAmbilHasilPengerjaan;
use App\Http\Controllers\ControllerAmbilInformasiSoal;
use App\Http\Controllers\ControllerAmbilSemuaTestcase;
use App\Http\Controllers\ControllerAmbilTestcasePublik;
use App\Http\Controllers\ControllerBuatSoal;
use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerLogout;
use App\Http\Controllers\ControllerPencarianSoal;
use App\Http\Controllers\ControllerPengecekTokenAutentikasi;
use App\Http\Controllers\ControllerRegister;
use App\Http\Controllers\ControllerSetTestcaseSoal;
use App\Http\Controllers\ControllerSubmitPengerjaan;
use App\Http\Controllers\ControllerTambahComment;
use App\Http\Controllers\ControllerUbahSoal;
use App\Http\Controllers\ControllerUjiCobaProgram;
use Illuminate\Http\Request;
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
    Route::post("/login", ControllerLogin::class)->name("login");
    Route::post("/register", ControllerRegister::class)->name("register");

    Route::get("/belum-login", function() {
        return response()->json(['error' => 'Belum Login'], 401);
    })->name("belum login");
});

Route::middleware("auth:api")->group(function() {
    Route::post("/login-token", ControllerPengecekTokenAutentikasi::class)->name("cek token autentikasi");
    Route::post("/logout", ControllerLogout::class)->name("logout");
    
    Route::post("/buat-soal", ControllerBuatSoal::class)->name("buat soal");
    Route::post("/ubah-soal", ControllerUbahSoal::class)->name("ubah soal");
    Route::post("/set-testcase", ControllerSetTestcaseSoal::class)->name("set testcase");
    Route::post("/tambah-comment", ControllerTambahComment::class)->name("tambah comment");
    Route::post("/jalankan-program", ControllerUjiCobaProgram::class)->name("jalankan program");
    Route::post("/submit-program", ControllerSubmitPengerjaan::class)->name("submit program");
    
    Route::get("/daftar-semua-testcase", ControllerAmbilSemuaTestcase::class)->name("ambil semua testcase");
    Route::get("/daftar-hasil-submission-soal", ControllerAmbilDaftarSubmissionSoal::class)->name("daftar hasil pengerjaan");
    Route::get("/hasil-submission-soal", ControllerAmbilHasilPengerjaan::class)->name("hasil pengerjaan");
});

Route::get("/informasi-soal", ControllerAmbilInformasiSoal::class)->name("informasi soal");
Route::get("/daftar-testcase-publik", ControllerAmbilTestcasePublik::class)->name("ambil semua testcase");
Route::get("/ambil-comment", ControllerAmbilComment::class)->name("ambil comment");
Route::get("/cari-soal", ControllerPencarianSoal::class)->name("cari-soal");
