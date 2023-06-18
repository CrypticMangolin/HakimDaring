<?php

namespace App\Http\Controllers;

use App\Application\Command\Autentikasi\Login\CommandLogin;
use App\Application\Command\Autentikasi\Login\RequestLogin;
use App\Application\Command\Autentikasi\Logout\CommandLogout;
use App\Application\Command\Autentikasi\Register\CommandRegister;
use App\Application\Command\Autentikasi\Register\RequestRegister;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ControllerAutentikasi extends Controller
{

    public function register(Request $request, CommandRegister $command) : JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            "nama" => "required",
            "email" => "required",
            "password"  => "required",
            "ulangi_password" => "required"
        ]);

        if ($validasi->fails()) {
            return response()->json([
                "error" => "Data tidak terisi dengan benar"
            ], 422);
        }

        $jsonRequest = $request->json()->all();

        try {

            $command->execute(new RequestRegister(
                $jsonRequest["email"],
                $jsonRequest["password"],
                $jsonRequest["ulangi_password"],
                $jsonRequest["nama"]
            ));
            return response()->json([
                "success" => "Berhasil membuat akun"
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 422);
        }
    }

    public function login(Request $request, CommandLogin $command) : JsonResponse 
    {

        $validasi = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                "error" => "Data tidak terisi dengan benar"
            ], 422);
        }

        $jsonRequest = $request->json()->all();

        try {
            $informasiLogin = $command->execute(new RequestLogin(
                $jsonRequest["email"],
                $jsonRequest["password"]
            ));

            return response()->json([
                "token" => $informasiLogin->ambilToken(),
                "nama" => $informasiLogin->ambilNama(),
                "id" => $informasiLogin->ambilIDUser()->ambilID(),
                "role" => session('role')
            ], 200);
        }
        catch(Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 401);
        }
    }

    public function logout(Request $request, CommandLogout $command) : JsonResponse {
        $command->execute();
        return response()->json([
            "success" => "OK"
        ], 200);
    }

    public function cekToken(Request $request) : JsonResponse
    {
        Auth::check();

        return response()->json([
            "success" => "token terautorisasi",
            "nama" => Auth::user()->nama,
            "id" => Auth::id()
        ], 200);
    }
}
