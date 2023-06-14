<?php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository\MySQL;

use App\Core\Repository\Pengerjaan\Entitas\Pengerjaan;
use App\Core\Repository\Pengerjaan\InterfaceRepositoryPengerjaan;
use Illuminate\Support\Facades\DB;

class RepositoryPengerjaanMySQL implements InterfaceRepositoryPengerjaan {

    public function save(Pengerjaan $pengerjaan) : void {
        DB::table("pengerjaan")->insert([
            "id_pengerjaan" => $pengerjaan->ambilIDPengerjaan()->ambilID(),
            "id_user" => $pengerjaan->ambilIDPengerja()->ambilID(),
            "id_soal" => $pengerjaan->ambilIDSoal()->ambilID(),
            "versi_soal" => $pengerjaan->ambilVersiSoal()->ambilVersi(),
            "source_code" => $pengerjaan->ambilSourceCode()->ambilSourceCode(),
            "bahasa" => $pengerjaan->ambilSourceCode()->ambilBahasa(),
            "hasil" => $pengerjaan->ambilHasil()->ambilHasil(),
            "total_waktu" => $pengerjaan->ambilHasil()->ambilTotalWaktu(),
            "total_memori" => $pengerjaan->ambilHasil()->ambilTotalMemori(),
            "tanggal_submit" => $pengerjaan->ambilTanggalSubmit()->format("Y-m-d H:i:s")
        ]);
    }

    public function update(Pengerjaan $pengerjaan) : void {
        DB::table("pengerjaan")->where("id_pengerjaan", "=", $pengerjaan->ambilIDPengerjaan()->ambilID())->update([
            "id_pengerjaan" => $pengerjaan->ambilIDPengerjaan()->ambilID(),
            "id_user" => $pengerjaan->ambilIDPengerja()->ambilID(),
            "id_soal" => $pengerjaan->ambilIDSoal()->ambilID(),
            "versi_soal" => $pengerjaan->ambilVersiSoal()->ambilVersi(),
            "source_code" => $pengerjaan->ambilSourceCode()->ambilSourceCode(),
            "bahasa" => $pengerjaan->ambilSourceCode()->ambilBahasa(),
            "hasil" => $pengerjaan->ambilHasil()->ambilHasil(),
            "total_waktu" => $pengerjaan->ambilHasil()->ambilTotalWaktu(),
            "total_memori" => $pengerjaan->ambilHasil()->ambilTotalMemori(),
            "tanggal_submit" => $pengerjaan->ambilTanggalSubmit()->format("Y-m-d H:i:s")
        ]);
    }
}

?>