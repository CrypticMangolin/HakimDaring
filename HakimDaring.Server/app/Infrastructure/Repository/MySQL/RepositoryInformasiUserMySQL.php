<?Php 

declare(strict_types = 1);

namespace App\Infrastructure\Repository\MySQL;

use App\Core\Repository\Autentikasi\Entitas\Email;
use App\Core\Repository\Autentikasi\Entitas\IDUser;
use App\Core\Repository\InformasiUser\Entitas\InformasiUser;
use App\Core\Repository\InformasiUser\Entitas\KelompokUser;
use App\Core\Repository\InformasiUser\Entitas\NamaUser;
use App\Core\Repository\InformasiUser\InterfaceRepositoryInformasiUser;
use DateTime;
use Illuminate\Support\Facades\DB;

class RepositoryInformasiUserMySQL implements InterfaceRepositoryInformasiUser {

    public function byEmail(Email $email) : ?InformasiUser {
        
        $script = "SELECT du.id_user, du.nama_user, du.email, du.kelompok, du.tanggal_bergabung FROM data_user AS du WHERE du.email = :email";
        $hasilQuery = DB::select($script, [
            "email" => $email->ambilEmail()
        ]);

        if (count($hasilQuery) == 0) {
            return null;
        }
        $hasil = $hasilQuery[0];
        return new InformasiUser(new IDUser($hasil->id_user), new NamaUser($hasil->nama_user), new Email($hasil->email), new KelompokUser($hasil->kelompok), new DateTime($hasil->tanggal_bergabung));
    }

    public function save(InformasiUser $informasiUser) : void {
        DB::table("data_user")->insert([
            "id_user" => $informasiUser->ambilIDUser()->ambilID(),
            "nama_user" => $informasiUser->ambilNamaUser()->ambilNama(),
            "email" => $informasiUser->ambilEmail()->ambilEmail(),
            "tanggal_bergabung" => $informasiUser->ambilTanggalBergabung()->format("Y-m-d H:i:s"),
            "kelompok" => $informasiUser->ambilKelompokUser()->ambilKelompok()
        ]);
    }

    public function update(InformasiUser $informasiUser) : void {
        DB::table("data_user")->where("id_user", "=", $informasiUser->ambilIDUser()->ambilID())->update([
            "id_user" => $informasiUser->ambilIDUser()->ambilID(),
            "nama_user" => $informasiUser->ambilNamaUser()->ambilNama(),
            "email" => $informasiUser->ambilEmail()->ambilEmail(),
            "tanggal_bergabung" => $informasiUser->ambilTanggalBergabung()->format("Y-m-d H:i:s"),
            "kelompok" => $informasiUser->ambilKelompokUser()->ambilKelompok()
        ]);
    }
}

?>