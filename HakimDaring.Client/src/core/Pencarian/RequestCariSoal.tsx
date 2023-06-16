import KategoriPencarian from "./Data/KategoriPencarian";
import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import BuatHeader from "../PembuatHeader";
import BerhasilMencari from "../Responses/ResponseBerhasil/Pencarian/BerhasilMencari";
import ResponseSoalPencarian from "../Responses/ResponseBerhasil/Pencarian/ResponseSoalPencarian";

class RequestCariSoal {
    
    public execute(kategoriPencarian: KategoriPencarian, callback: (hasil: any) => void): void {

        fetch(`http://127.0.0.1:8000/api/cari?halaman=${kategoriPencarian.halaman}&judul=${kategoriPencarian.judul}&sort_by=${kategoriPencarian.sort_by}&sort_reverse=${kategoriPencarian.sort_reverse}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilMencari(
                    dataDariServer.halaman,
                    dataDariServer.total_halaman,
                    dataDariServer.hasil_pencarian as ResponseSoalPencarian[]
                ))
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

export default RequestCariSoal