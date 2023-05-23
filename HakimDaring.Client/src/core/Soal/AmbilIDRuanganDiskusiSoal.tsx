import IDRuangan from "../Data/IDRuanganComment";
import IDSoal from "../Data/IDSoal";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import InterfaceAmbilIDRuanganDikusiSoal from "./Interface/InterfaceAmbilIDRuanganDikusiSoal";

class AmbilIDRuanganDiskusiSoal implements InterfaceAmbilIDRuanganDikusiSoal {

    ambilIDRuangan( idSoal: IDSoal, callback : (hasil : any) => void) : void {
        fetch(`http://127.0.0.1:8000/api/informasi-soal?id_soal=${idSoal.id}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new IDRuangan(
                    dataDariServer.id_ruangan_diskusi
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

export default AmbilIDRuanganDiskusiSoal