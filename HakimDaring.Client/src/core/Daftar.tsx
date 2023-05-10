import AkunRegister from "./Data/AkunRegister";
import BerhasilDaftar from "./Data/ResponseBerhasil/BerhasilDaftar";
import KesalahanInputData from "./Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "./Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "./Data/ResponseGagal/TidakMemilikiHak";
import InterfaceDaftar from "./Interface/InterfaceDaftar";
import BuatHeader from "./PembuatHeader";

class Daftar implements InterfaceDaftar {
    
    public daftar(dataAkun: AkunRegister, callback: (hasil: any) => void): void {
        fetch("http://127.0.0.1:8000/api/register", {
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

export default Daftar