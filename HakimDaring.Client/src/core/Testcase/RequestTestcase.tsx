import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import ResponseTestcase from "../Responses/ResponseBerhasil/Soal/ResponseTestcase";

class RequestTestcase {

    public execute(idSoal : string, callback: (hasil: any) => void): void {
        fetch(`http://127.0.0.1:8000/api/testcase?id_soal=${idSoal}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader(),
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(dataDariServer as ResponseTestcase[])
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

export default RequestTestcase