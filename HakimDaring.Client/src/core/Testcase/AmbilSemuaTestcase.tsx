import IDSoal from "../Data/IDSoal";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import Testcase from "../Data/Testcase";
import InterfaceAmbilSemuaTestcase from "./Interface/InterfaceAmbilSemuaTestcase";
import BuatHeader from "../PembuatHeader";

class AmbilSemuaTestcase implements InterfaceAmbilSemuaTestcase {

    ambilSemuaTestcase(idSoal: IDSoal, callback : (hasil : any) => void): void {
        fetch("http://127.0.0.1:8000/api/daftar-semua-testcase", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify({
                id_soal : idSoal.id
            })
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                let hasil = []
                for (let i = 0; i < dataDariServer.length; i++) {
                    hasil.push(new Testcase(
                        dataDariServer[i].testcase,
                        dataDariServer[i].jawaban,
                        dataDariServer[i].urutan,
                        dataDariServer[i].publik
                    ))
                }
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

export default AmbilSemuaTestcase