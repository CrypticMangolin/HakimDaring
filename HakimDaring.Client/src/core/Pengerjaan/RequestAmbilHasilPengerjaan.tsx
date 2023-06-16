import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import BerhasilAmbilHasilPengerjaan from "../Responses/ResponseBerhasil/Pengerjaan/BerhasilAmbilHasilPengerjaan";
import ResponseHasilPengerjaanTestcase from "../Responses/ResponseBerhasil/Pengerjaan/ResponseHasilPengerjaanTestcase";

class RequestAmbilHasilPengerjaan {

    public execute(idPengerjaan : string, callback : (hasil : any) => void) : void {
        fetch(`http://localhost:8000/api/pengerjaan/hasil?id_pengerjaan=${idPengerjaan}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()
            console.log(dataDariServer)
            if (response.ok) {
                callback(new BerhasilAmbilHasilPengerjaan(
                    dataDariServer.id_pengerjaan,
                    dataDariServer.id_user,
                    dataDariServer.nama_user,
                    dataDariServer.id_soal,
                    dataDariServer.judul_soal,
                    dataDariServer.source_code,
                    dataDariServer.bahasa,
                    dataDariServer.hasil,
                    dataDariServer.total_waktu,
                    dataDariServer.total_memori,
                    dataDariServer.tanggal_submit,
                    dataDariServer.outdated,
                    dataDariServer.hasil_testcase as ResponseHasilPengerjaanTestcase[]
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

export default RequestAmbilHasilPengerjaan