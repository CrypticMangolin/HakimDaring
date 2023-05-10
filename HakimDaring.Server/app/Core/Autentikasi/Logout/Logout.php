<?php 

declare(strict_types = 1);

namespace App\Core\Autentikasi\Logout;

use App\Core\Autentikasi\Logout\Interface\InterfaceLogout;
use App\Models\User;
use ErrorException;
use Illuminate\Support\Facades\Auth;

class Logout implements InterfaceLogout {

    public function logout() : void {
        $user = Auth::user();

        if (!($user instanceof User)) {
            throw new ErrorException("Kesalahan pengaturan kelas user");
        }

        $user->token()->revoke();
    }
}

?>