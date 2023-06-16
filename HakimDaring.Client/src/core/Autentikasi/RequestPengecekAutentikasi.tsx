import BerhasilMasuk from "../Responses/ResponseBerhasil/Autentikasi/BerhasilMasuk";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import CekMemilikiTokenAutentikasi from "./CekMemilikiTokenAutentikasi";

class RequestPengecekAutentikasi {

    private pengecekMemilikiTokenAutentikasi : CekMemilikiTokenAutentikasi

    constructor(pengecekMemilikiTokenAutentikasi : CekMemilikiTokenAutentikasi) {
        this.pengecekMemilikiTokenAutentikasi = pengecekMemilikiTokenAutentikasi
    }

    public execute(callback: (hasil: any) => void): void {
        
        if (!this.pengecekMemilikiTokenAutentikasi.cekApakahMemilikiTokenAutentikasi()) {
            callback(new TidakMemilikiHak("tidak memiliki token"))
        }
        else {
            fetch("http://127.0.0.1:8000/api/autentikasi/login-token", {
                method : 'POST',
                mode: "cors",
                headers : BuatHeader()
            }).then(async (response) => {
                const dataDariServer = await response.json()
    
                if (response.ok) {
                    localStorage.setItem("nama", dataDariServer.nama)
                    localStorage.setItem("id", dataDariServer.id)
                    callback(new BerhasilMasuk())
                }
                else if (response.status == 401) {
                    localStorage.removeItem("token")
                    callback(new TidakMemilikiHak(dataDariServer.error))
                }
                else {
                    callback(new KesalahanInternalServer(dataDariServer.error))
                }
            })
        }
    }
    
}

export default RequestPengecekAutentikasi