import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import HapusComment from "./Data/HapusComment";
import BerhasilMenghapusComment from "../Responses/ResponseBerhasil/Comment/BerhasilMenghapusComment";

class RequestHapusComment {

    public execute(hapusComment : HapusComment, callback: (hasil: any) => void): void {
        
        fetch(`http://127.0.0.1:8000/api/comment/hapus?id_ruangan=${hapusComment.id_ruangan}&id_comment=${hapusComment.id_comment}`, {
            method: "DELETE",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilMenghapusComment())
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

export default RequestHapusComment