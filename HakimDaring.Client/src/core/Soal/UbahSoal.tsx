import BerhasilUbahSoal from "../Data/ResponseBerhasil/BerhasilUbahSoal";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import SoalUbah from "../Data/SoalUbah";
import InterfaceUbahSoal from "./Interface/InterfaceUbahSoal";
import BuatHeader from "../PembuatHeader";

class UbahSoal implements InterfaceUbahSoal {

    ubahSoal(soal: SoalUbah, callback: (hasil: any) => void): void {
        fetch("http://127.0.0.1:8000/api/ubah-soal", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify({
                id_soal : soal.idSoal.id,
                judul : soal.soal.judul,
                soal : soal.soal.soal
            })
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilUbahSoal())
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

export default UbahSoal