import IDSoal from "../Data/IDSoal";
import BerhasilBuatSoal from "../Data/ResponseBerhasil/BerhasilBuatSoal";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import Soal from "../Data/Soal";
import InterfaceBuatSoal from "./Interface/InterfaceBuatSoal";
import BuatHeader from "../PembuatHeader";

class BuatSoal implements InterfaceBuatSoal {

    public buatSoal(dataSoal: Soal, callback: (hasil: any) => void): void {
        
        fetch("http://127.0.0.1:8000/api/buat-soal", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify({
                judul : dataSoal.judul,
                soal : dataSoal.soal
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