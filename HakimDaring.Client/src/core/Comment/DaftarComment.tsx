import Comment from "../Data/Comment";
import IDComment from "../Data/IDComment";
import IDRuanganComment from "../Data/IDRuanganComment";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Data/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import InterfaceDaftarComment from "./Interface/InterfaceDaftarComment";

class DaftarComment implements InterfaceDaftarComment {

    ambilDaftarComment(idRuangan: IDRuanganComment, callback : (hasil : any) => void) : void {
        fetch(`http://127.0.0.1:8000/api/ambil-comment?id_ruangan_comment=${idRuangan.id}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                let daftarComment : Comment[] = []
                
                let daftar : any[] = dataDariServer as any[]

                for(let i = 0; i < daftar.length; i++) {
                    daftarComment.push(new Comment(
                        new IDComment(daftar[i].id),
                        daftar[i].nama_penulis,
                        daftar[i].pesan,
                        new Date(daftar[i]),
                        daftar[i].reply === undefined ? null : new IDComment(daftar[i].reply)
                    ))
                }

                callback(daftarComment)
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

export default DaftarComment