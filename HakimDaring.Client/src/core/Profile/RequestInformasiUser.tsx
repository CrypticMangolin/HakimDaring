import BuatHeader from "../PembuatHeader"
import BerhasilMengambilUserInfo from "../Responses/ResponseBerhasil/Profile/BerhasilMengambilUserInfo"
import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData"
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer"
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak"

class RequestInformasiUser {
    public execute(callback : (hasil : any) => void) : void {
        
        fetch(`http://127.0.0.1:8000/api/profile`, {
            method: "POST",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()
            
            if (response.ok) {
                callback(new BerhasilMengambilUserInfo(
                    dataDariServer.nama,
                    dataDariServer.email,
                    dataDariServer.role,
                    dataDariServer.tgl_bergabung
                ))
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

export default RequestInformasiUser