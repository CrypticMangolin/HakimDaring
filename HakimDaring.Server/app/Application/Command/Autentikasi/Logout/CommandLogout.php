<?php 

declare(strict_types = 1);

namespace App\Application\Command\Autentikasi\Logout;

use App\Application\Command\Soal\Exception\ApplicationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommandLogout {

    public function execute() : void {
        $user = Auth::user();

        if (!($user instanceof User)) {
            throw new ApplicationException("kesalahan pengaturan kelas user");
        }

        $user->token()->revoke();
    }
}

?>