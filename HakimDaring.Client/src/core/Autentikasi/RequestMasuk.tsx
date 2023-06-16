import AkunLogin from "./Data/AkunLogin";
import BerhasilMasuk from "../Responses/ResponseBerhasil/Autentikasi/BerhasilMasuk";
import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";

class RequestMasuk {
    
    public execute(dataAkun : AkunLogin, callback : (hasil : any) => void) : void {

        fetch("http://127.0.0.1:8000/api/autentikasi/login", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify(dataAkun)
        }).then(async (response) => {
            const dataDariServer = await response.json()
            
            if (response.ok) {
                localStorage.setItem("token", dataDariServer.token)
                localStorage.setItem("nama", dataDariServer.nama)
                localStorage.setItem("id", dataDariServer.id)
                callback(new BerhasilMasuk())
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

export default RequestMasuk