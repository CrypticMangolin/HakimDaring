import BerhasilMasuk from "./Data/ResponseBerhasil/BerhasilMasuk";
import KesalahanInternalServer from "./Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "./Data/ResponseGagal/TidakMemilikiHak";
import InterfacePengecekAutentikasi from "./Interface/InterfacePengecekAutentikasi";
import BuatHeader from "./PembuatHeader";

class PengecekAutentikasi implements InterfacePengecekAutentikasi {
    
    public cekApakahSudahTerautentikasi(callback: (hasil: any) => void): void {
        
        if (localStorage.getItem('token') == null) {
            callback(new TidakMemilikiHak("tidak memiliki token"))
        }
        else {
            fetch("http://127.0.0.1:8000/api/login-token", {
                method : 'POST',
                mode: "cors",
                headers : BuatHeader()
            }).then(async (response) => {
                const dataDariServer = await response.json()
    
                if (response.ok) {
                    localStorage.setItem("nama", dataDariServer.nama)
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

export default PengecekAutentikasi