import ContohInput from "../Data/ContohInput";
import IDSoal from "../Data/IDSoal";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import InterfaceAmbilTestcasePublik from "./Interface/InterfaceAmbilTestcasePublik";

class AmbilTestcasePublik implements InterfaceAmbilTestcasePublik {

    ambilTestcase(idSoal : IDSoal, callback : (hasil : any) => void) : void {
        fetch(`http://localhost:8000/api/daftar-testcase-publik?id_soal=${idSoal.id}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok && Array.isArray(dataDariServer)) {
                let hasil : ContohInput[] = [] 

                dataDariServer.forEach((value : any) => {
                    hasil.push(new ContohInput(
                        value.testcase,
                        value.jawaban
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

export default AmbilTestcasePublik