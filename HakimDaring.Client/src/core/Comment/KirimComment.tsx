import Comment from "../Data/Comment";
import IDComment from "../Data/IDComment";
import IDRuanganComment from "../Data/IDRuanganComment";
import BerhasilMengirimComment from "../Data/ResponseBerhasil/BerhasilMengirimComment";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import InterfaceKirimComment from "./Interface/InterfaceKirimComment";

class KirimComment implements InterfaceKirimComment {
    kirimComment(idRuangan: IDRuanganComment, pesan: string, reply: IDComment | null, callback: (hasil: any) => void): void {
        let dataComment : any = {
            id_ruangan_comment : idRuangan.id,
            pesan : pesan,
        }

        if (reply != null) {
            dataComment = {...dataComment, reply : reply.id}
        }

        fetch("http://127.0.0.1:8000/api/tambah-comment", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify(dataComment)
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilMengirimComment())
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

export default KirimComment