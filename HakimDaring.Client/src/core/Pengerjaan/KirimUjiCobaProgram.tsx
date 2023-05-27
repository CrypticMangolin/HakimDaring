import BerhasilUjiCobaProgram from "../Data/ResponseBerhasil/BerhasilUjiCobaProgram";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import UjiCoba from "../Data/UjiCoba";
import BuatHeader from "../PembuatHeader";
import InterfaceKirimUjiCobaProgram from "./Interface/InterfaceKirimUjiCobaProgram";

class KirimUjiCobaProgram implements InterfaceKirimUjiCobaProgram {

    kirimUjiCoba(ujiCoba : UjiCoba, callback : (hasil : any) => void) : void {
        fetch("http://localhost:8000/api/jalankan-program", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify({
                id_soal : ujiCoba.idSoal,
                source_code : ujiCoba.sourceCode,
                bahasa : ujiCoba.bahasa,
                stdin : ujiCoba.input
            })
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok && Array.isArray(dataDariServer)) {
                let hasil : BerhasilUjiCobaProgram[] = [] 

                dataDariServer.forEach((value : any) => {
                    hasil.push(new BerhasilUjiCobaProgram(
                        value.error != null ? value.error : value.stdout,
                        value.waktu,
                        value.memori,
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

export default KirimUjiCobaProgram