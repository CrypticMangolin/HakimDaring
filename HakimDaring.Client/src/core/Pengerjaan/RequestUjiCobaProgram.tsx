import BerhasilUjiCobaProgram from "../Responses/ResponseBerhasil/Pengerjaan/BerhasilUjiCobaProgram";
import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import UjiCoba from "./Data/UjiCoba";
import BuatHeader from "../PembuatHeader";

class RequestUjiCobaProgram {

    public execute(ujiCoba : UjiCoba, callback : (hasil : any) => void) : void {
        
        fetch("http://localhost:8000/api/program/uji", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify(ujiCoba)
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

export default RequestUjiCobaProgram