<?php

namespace App\Http\Controllers;

use App\Core\Autentikasi\Logout\Interface\InterfaceLogout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ControllerLogout extends Controller
{
    private InterfaceLogout $logout;

    public function __construct(InterfaceLogout $logout)
    {
        if ($logout == null) {
            throw new InvalidArgumentException("logout bernilai nulll");
        }

        $this->logout = $logout;
    }

    public function __invoke(Request $request) : JsonResponse
    {
        $this->logout->logout();
        return response()->json(["success" => "token terautorisasi"], 200);
    }
}
