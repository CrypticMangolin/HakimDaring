import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import BerhasilMengambilDaftarComment from "../Responses/ResponseBerhasil/Comment/BerhasilMengambilDaftarComment";

class RequestDaftarComment {

    public execute(idRuangan: string, callback : (hasil : any) => void) : void {
        fetch(`http://127.0.0.1:8000/api/comment/daftar?id_ruangan_comment=${idRuangan}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                let daftarComment : BerhasilMengambilDaftarComment[] = []
                
                let daftar : any[] = dataDariServer as any[]

                for(let i = 0; i < daftar.length; i++) {
                    daftarComment.push(new BerhasilMengambilDaftarComment(
                        daftar[i].id_comment,
                        daftar[i].id_penulis,
                        daftar[i].nama_penulis,
                        daftar[i].isi,
                        daftar[i].reply,
                        daftar[i].tanggal_penulisan,
                        daftar[i].status
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

export default RequestDaftarComment