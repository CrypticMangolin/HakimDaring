<?php

namespace App\Http\Controllers;

use App\Core\Autentikasi\Register\Data\GagalRegisterException;
use App\Core\Autentikasi\Register\InterfaceRegister;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ControllerRegister extends Controller
{
    private InterfaceRegister $register;

    public function __construct(InterfaceRegister $register)
    {
        if ($register == null) {
            throw new InvalidArgumentException("register Null");
        }
        $this->register = $register;
    }

    public function __invoke(Request $request) : JsonResponse
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

        try {
            $nama = $request->post("nama");
            $email = $request->post("email");
            $password = $request->post("password");
            $ulangiPassword = $request->post("ulangi_password");
            if ($this->register->register($nama, $email, $password, $ulangiPassword)) {
                return response()->json([
                    "success" => "Berhasil membuat akun"
                ], 200);
            }
            else {
                return response()->json([
                    "error" => "Gagal Membuat Akun"
                ], 500);
            }
        }
        catch (GagalRegisterException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }

        return response()->json([
            "error" => "Gagal Membuat Akun"
        ], 500);
    }
}
