import IDSoal from "../Data/IDSoal";
import InformasiSoal from "../Data/InformasiSoal";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import InterfaceAmbilInformasiSoal from "./Interface/InterfaceAmbilInformasiSoal";
import BuatHeader from "../PembuatHeader";

class AmbilInformasiSoal implements InterfaceAmbilInformasiSoal {

    ambilInformasiSoal(idSoal : IDSoal, callback : (hasil : any) => void) : void {
        fetch(`http://127.0.0.1:8000/api/informasi-soal?id_soal=${idSoal.id}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new InformasiSoal(
                    new IDSoal(dataDariServer.id_soal),
                    dataDariServer.judul,
                    dataDariServer.soal,
                    dataDariServer.versi,
                    dataDariServer.status,
                    dataDariServer.batasan_waktu_per_testcase_dalam_sekon,
                    dataDariServer.batasan_waktu_total_semua_testcase_dalam_sekon,
                    dataDariServer.batasan_memori_dalam_kb,
                    dataDariServer.jumlah_submit,
                    dataDariServer.jumlah_berhasil
                ))
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

export default AmbilInformasiSoal