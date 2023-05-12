import IDSoal from "./Data/IDSoal";
import BerhasilBuatSoal from "./Data/ResponseBerhasil/BerhasilBuatSoal";
import KesalahanInputData from "./Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "./Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "./Data/ResponseGagal/TidakMemilikiHak";
import SoalBaru from "./Data/SoalBaru";
import InterfaceBuatSoal from "./Interface/InterfaceBuatSoal";
import BuatHeader from "./PembuatHeader";

class BuatSoal implements InterfaceBuatSoal {

    public buatSoal(dataSoal: SoalBaru, callback: (hasil: any) => void): void {
        console.log(dataSoal)
        fetch("http://127.0.0.1:8000/api/buat-soal", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify({
                judul : dataSoal.judul,
                soal : dataSoal.soal,
                batasan_waktu_per_testcase_dalam_sekon : dataSoal.batasan_waktu_per_testcase_dalam_sekon.toFixed(3),
                batasan_waktu_total_semua_testcase_dalam_sekon : dataSoal.batasan_waktu_total_semua_testcase_dalam_sekon.toFixed(3),
                batasan_memori_dalam_kb : dataSoal.batasan_memori_dalam_kb
            })
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilBuatSoal(new IDSoal(dataDariServer.id_soal)))
            }
            else if (response.status == 401) {
                callback(new TidakMemilikiHak(dataDariServer.error))
            }
            else if (response.status == 422) {
                callback(new KesalahanInputData(dataDariServer.error))
            }
            else if (response.status == 500) {
                callback(new KesalahanInternalServer(dataDariServer.error))
            }
        })
    }
}

export default BuatSoal