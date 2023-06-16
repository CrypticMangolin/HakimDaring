<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository\MySQL;

use App\Core\Repository\Pengerjaan\Entitas\PengerjaanTestcase;
use App\Core\Repository\Pengerjaan\InterfaceRepositoryPengerjaanTestcase;
use Illuminate\Support\Facades\DB;

class RepositoryPengerjaanTestcaseMySQL implements InterfaceRepositoryPengerjaanTestcase {

    public function save(PengerjaanTestcase $pengerjaan) : void {

        DB::table("hasil_testcase_pengerjaan")->insert([
            "id_pengerjaan" => $pengerjaan->ambilIDPengerjaan()->ambilID(),
            "id_testcase" => $pengerjaan->ambilIDTestcase()->ambilID(),
            "status" => $pengerjaan->ambilHasil()->ambilHasil(),
            "waktu" => $pengerjaan->ambilHasil()->ambilWaktu(),
            "memori" => $pengerjaan->ambilHasil()->ambilMemori()
        ]);
    }
}

?>