import IDPengerjaan from "../Data/IDPengerjaan";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import SubmitPengerjaan from "../Data/SubmitPengerjaan";
import BuatHeader from "../PembuatHeader";
import InterfaceKirimPengerjaan from "./Interface/InterfaceKirimPengerjaan";

class KirimPengerjaan implements InterfaceKirimPengerjaan {

    kirimPengerjaanProgram(pengerjaan : SubmitPengerjaan, callback : (hasil : any) => void) : void {
        console.log(JSON.stringify({
            id_soal : pengerjaan.idSoal.id,
            source_code : pengerjaan.sourceCode,
            bahasa : pengerjaan.bahasa
        }))
        fetch("http://localhost:8000/api/submit-program", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify({
                id_soal : pengerjaan.idSoal.id,
                source_code : pengerjaan.sourceCode,
                bahasa : pengerjaan.bahasa
            })
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new IDPengerjaan(dataDariServer.id_pengerjaan))
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

export default KirimPengerjaan