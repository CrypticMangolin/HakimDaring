import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import BuatSoal from "./Data/BuatSoal";
import BerhasilBuatSoal from "../Responses/ResponseBerhasil/Soal/BerhasilBuatSoal";

class RequestBuatSoal {

    public execute(soal: BuatSoal, callback: (hasil: any) => void): void {
        fetch("http://127.0.0.1:8000/api/soal/buat", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify(soal)
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilBuatSoal(dataDariServer.id_soal))
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
        }).catch(async (reason : any) => {
            
            console.log(reason)
        })
    }
}

export default RequestBuatSoal