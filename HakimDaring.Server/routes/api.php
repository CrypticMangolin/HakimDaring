<?php

use App\Http\Controllers\ControllerBuatSoal;
use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerLogout;
use App\Http\Controllers\ControllerPengecekTokenAutentikasi;
use App\Http\Controllers\ControllerRegister;
use App\Http\Controllers\ControllerSetTestcaseSoal;
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
    Route::post("/set-testcase", ControllerSetTestcaseSoal::class)->name("set testcase");
});
