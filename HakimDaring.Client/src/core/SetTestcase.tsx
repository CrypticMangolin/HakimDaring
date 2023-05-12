import IDSoal from "./Data/IDSoal";
import BerhasilSetTestcase from "./Data/ResponseBerhasil/BerhasilSetTestcase";
import KesalahanInputData from "./Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "./Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "./Data/ResponseGagal/TidakMemilikiHak";
import Testcase from "./Data/Testcase";
import InterfaceSetTestcase from "./Interface/InterfaceSetTestcase";
import BuatHeader from "./PembuatHeader";

class SetTestcase implements InterfaceSetTestcase {

    public setTestcase(idSoal : IDSoal, daftarTestcase: Testcase[], callback: (hasil: any) => void): void {
        console.log(JSON.stringify({
            id_soal : idSoal.id,
            daftar_testcase : JSON.stringify(daftarTestcase)
        }))
        
        fetch("http://127.0.0.1:8000/api/set-testcase", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify({
                id_soal : idSoal.id,
                daftar_testcase : daftarTestcase
            })
        }).then(async (response) => {
            let dataDariServer = await response.json()

            console.log(dataDariServer)
            if (response.ok) {
                callback(new BerhasilSetTestcase())
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

export default SetTestcase