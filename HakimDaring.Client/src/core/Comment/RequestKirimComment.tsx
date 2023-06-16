import Comment from "./Data/Comment";
import BerhasilMengirimComment from "../Responses/ResponseBerhasil/Comment/BerhasilMengirimComment";
import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";

class RequestKirimComment {

    public execute(comment : Comment, callback: (hasil: any) => void): void {

        fetch("http://127.0.0.1:8000/api/comment/tambah", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader(),
            body: JSON.stringify(comment)
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

export default RequestKirimComment