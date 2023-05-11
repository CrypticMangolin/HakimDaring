import AkunLogin from "./Data/AkunLogin";
import BerhasilMasuk from "./Data/ResponseBerhasil/BerhasilMasuk";
import KesalahanInputData from "./Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "./Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "./Data/ResponseGagal/TidakMemilikiHak";
import InterfaceMasuk from "./Interface/InterfaceMasuk";
import BuatHeader from "./PembuatHeader";

class Masuk implements InterfaceMasuk {
    
    public masuk(dataAkun : AkunLogin, callback : (hasil : any) => void) : void {

        fetch("http://127.0.0.1:8000/api/login", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify(dataAkun)
        }).then(async (response) => {
            const dataDariServer = await response.json()
            
            if (response.ok) {
                localStorage.setItem("token", dataDariServer.token)
                localStorage.setItem("nama", dataDariServer.nama)
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

export default Masuk