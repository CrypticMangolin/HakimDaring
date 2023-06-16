import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import BerhasilAmbilInformasiSoal from "../Responses/ResponseBerhasil/Soal/BerhasilAmbilInformasiSoal";
import ResponseBatasanSoal from "../Responses/ResponseBerhasil/Soal/ResponseBatasanSoal";

class RequestAmbilInformasiSoal {

    public execute(idSoal : string, callback : (hasil : any) => void) : void {
        fetch(`http://127.0.0.1:8000/api/soal/informasi/publik?id_soal=${idSoal}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilAmbilInformasiSoal(
                    dataDariServer.id_soal,
                    dataDariServer.judul,
                    dataDariServer.soal,
                    {
                        waktu_per_testcase: dataDariServer.batasan.waktu_per_testcase, 
                        waktu_total: dataDariServer.batasan.waktu_total, 
                        memori: dataDariServer.batasan.memori
                    } as ResponseBatasanSoal,
                    dataDariServer.jumlah_submit,
                    dataDariServer.jumlah_berhasil,
                    dataDariServer.status,
                    dataDariServer.id_ruangan_diskusi,
                    dataDariServer.id_pembuat,
                    dataDariServer.nama_pembuat,
                ))
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

export default RequestAmbilInformasiSoal