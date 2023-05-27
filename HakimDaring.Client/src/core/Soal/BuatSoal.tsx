import IDSoal from "../Data/IDSoal";
import BerhasilBuatSoal from "../Data/ResponseBerhasil/BerhasilBuatSoal";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import Soal from "../Data/Soal";
import InterfaceBuatSoal from "./Interface/InterfaceBuatSoal";
import BuatHeader from "../PembuatHeader";
import BatasanSoal from "../Data/BatasanSoal";
import Testcase from "../Data/Testcase";

class BuatSoal implements InterfaceBuatSoal {

    public buatSoal(dataSoal: Soal, batasanBaru : BatasanSoal, daftarTestcase: Testcase[], callback: (hasil: any) => void): void {
        console.log(JSON.stringify({
            judul : dataSoal.judul,
            soal : dataSoal.soal,
            daftar_testcase : daftarTestcase,
            batasan : {
                batasan_waktu_per_testcase_dalam_sekon : batasanBaru.batasan_waktu_per_testcase_dalam_sekon.toFixed(3),
                batasan_waktu_total_semua_testcase_dalam_sekon : batasanBaru.batasan_waktu_total_semua_testcase_dalam_sekon.toFixed(3),
                batasan_memori_dalam_kb : batasanBaru.batasan_memori_dalam_kb
            }}))
        fetch("http://127.0.0.1:8000/api/buat-soal", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify({
                judul : dataSoal.judul,
                soal : dataSoal.soal,
                daftar_testcase : daftarTestcase,
                batasan : {
                    batasan_waktu_per_testcase_dalam_sekon : batasanBaru.batasan_waktu_per_testcase_dalam_sekon.toFixed(3),
                    batasan_waktu_total_semua_testcase_dalam_sekon : batasanBaru.batasan_waktu_total_semua_testcase_dalam_sekon.toFixed(3),
                    batasan_memori_dalam_kb : batasanBaru.batasan_memori_dalam_kb
                }
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
        }).catch(async (reason : any) => {
            
            console.log(reason)
        })
    }
}

export default BuatSoal