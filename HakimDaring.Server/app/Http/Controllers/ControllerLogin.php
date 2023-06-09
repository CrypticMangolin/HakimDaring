<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Autentikasi\Login\Exception\GagalLoginException;
use App\Core\Autentikasi\Login\Interfaces\InterfaceLogin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ControllerLogin extends Controller
{
    private InterfaceLogin $pemrosesLogin;

    public function __construct(InterfaceLogin $pemrosesLogin)
    {
        if ($pemrosesLogin == null) {
            throw new InvalidArgumentException("pemrosesLogin Null");
        }

        $this->pemrosesLogin = $pemrosesLogin;
    }
    
    public function __invoke(Request $request) : JsonResponse 
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

        $email = $request->post("email");
        $password = $request->post("password");

        try {
            $token_autentikasi = $this->pemrosesLogin->login($email, $password);
            $nama = Auth::user()->nama;

            return response()->json([
                "token" => $token_autentikasi,
                "nama" => $nama
            ], 200);
        }
        catch(GagalLoginException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 401);
        }

        return response()->json([
            "error" => "Kesalahan internal server"
        ], 500);
    }
}
