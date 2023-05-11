<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerPengecekTokenAutentikasi extends Controller
{
    public function __invoke(Request $request) : JsonResponse
    {
        Auth::check();

        return response()->json([
            "success" => "token terautorisasi",
            "nama" => Auth::user()->nama
        ], 200);
    }
}
