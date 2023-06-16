import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import SubmitPengerjaan from "./Data/SubmitPengerjaan";
import BuatHeader from "../PembuatHeader";
import BerhasilSubmitPengerjaan from "../Responses/ResponseBerhasil/Pengerjaan/BerhasilSubmitPengerjaan";

class RequestSubmitPengerjaan {

    public execute(pengerjaan : SubmitPengerjaan, callback : (hasil : any) => void) : void {
        fetch("http://localhost:8000/api/program/submit", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify(pengerjaan)
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilSubmitPengerjaan(dataDariServer.id_pengerjaan))
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

export default RequestSubmitPengerjaan