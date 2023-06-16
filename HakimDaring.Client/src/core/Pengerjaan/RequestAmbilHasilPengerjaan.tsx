import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import BerhasilAmbilDaftarPengerjaan from "../Responses/ResponseBerhasil/Pengerjaan/BerhasilAmbilDaftarPengerjaan";

class RequestAmbilHasilPengerjaan {

    public execute(idPengerjaan : string, callback : (hasil : any) => void) : void {
        fetch(`http://localhost:8000/api/pengerjaan/hasil?id_pengerjaan=${idPengerjaan}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok && Array.isArray(dataDariServer)) {
                let hasil : BerhasilAmbilDaftarPengerjaan[] = [] 

                dataDariServer.forEach((value : any) => {
                    hasil.push(new BerhasilAmbilDaftarPengerjaan(
                        value.id_pengerjaan,
                        value.id_soal,
                        value.judul_soal,
                        value.bahasa,
                        value.hasil,
                        value.total_waktu,
                        value.total_memori,
                        value.tanggal_submit,
                        value.outdated
                    ))
                })

                callback(hasil)
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