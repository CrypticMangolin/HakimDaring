import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import GantiStatus from "./Data/GantiStatus";
import BerhasilGantiSoal from "../Responses/ResponseBerhasil/Soal/BerhasilGantiSoal";

class RequestGantiSoal {

    public execute(gantiStatus: GantiStatus, callback: (hasil: any) => void): void {
        
        fetch(`http://127.0.0.1:8000/api/soal/ganti?id_soal=${gantiStatus.id_soal}&status=${gantiStatus.status}`, {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilGantiSoal())
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

export default RequestGantiSoal