import AkunRegister from "./Data/AkunRegister";
import BerhasilDaftar from "../Responses/ResponseBerhasil/Autentikasi/BerhasilDaftar";
import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";

class RequestDaftar {
    
    public execute(dataAkun: AkunRegister, callback: (hasil: any) => void): void {
        fetch("http://127.0.0.1:8000/api/autentikasi/register", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify(dataAkun)
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilDaftar())
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

export default RequestDaftar