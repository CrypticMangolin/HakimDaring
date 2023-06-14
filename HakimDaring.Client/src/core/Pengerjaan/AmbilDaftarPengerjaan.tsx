import HasilRingkasanPengerjaan from "../Data/HasilRingkasanPengerjaan";
import IDSoal from "../Data/IDSoal";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import InterfaceAmbilDaftarPengerjaan from "./Interface/InterfaceAmbilDaftarPengerjaan";

class AmbilDaftarPengerjaan implements InterfaceAmbilDaftarPengerjaan {

    ambil(idSoal : IDSoal, callback : (hasil : any) => void) : void {
        fetch(`http://localhost:8000/api/daftar-hasil-submission-soal?id_soal=${idSoal.id}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok && Array.isArray(dataDariServer)) {
                let hasil : HasilRingkasanPengerjaan[] = [] 

                dataDariServer.forEach((value : any) => {
                    hasil.push(new HasilRingkasanPengerjaan(
                        value.id_pengerjaan,
                        value.bahasa,
                        value.hasil,
                        new Date(value.tanggal_submit),
                        value.total_waktu,
                        value.total_memori,
                        value.status
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

export default AmbilDaftarPengerjaan