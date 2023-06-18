<?php

namespace App\Http\Controllers;

use App\Application\Command\Profile\CommandViewProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ControllerProfile extends Controller
{
    public function profile(Request $request, CommandViewProfile $command) : JsonResponse
    {
        $userInfo = $command->execute();
        return response()->json([
            "nama" => $userInfo->ambilNamaUser()->ambilNama(),
            "email" => $userInfo->ambilEmail()->ambilEmail(),
            "role" => $userInfo->ambilKelompokUser()->ambilKelompok(),
            "tgl_bergabung" => $userInfo->ambilTanggalBergabung()->format('d-m-Y')
        ], 200);
    }
}

?>