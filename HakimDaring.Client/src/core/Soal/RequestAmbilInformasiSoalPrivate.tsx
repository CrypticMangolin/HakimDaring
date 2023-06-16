import KesalahanInputData from "../Responses/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Responses/ResponseGagal/KesalahanInternalServer";
import TidakMemilikiHak from "../Responses/ResponseGagal/TidakMemilikiHak";
import BuatHeader from "../PembuatHeader";
import BerhasilAmbilInformasiSoalPrivate from "../Responses/ResponseBerhasil/Soal/BerhasilAmbilInformasiSoalPrivate";
import ResponseBatasanSoal from "../Responses/ResponseBerhasil/Soal/ResponseBatasanSoal";
import ResponseTestcase from "../Responses/ResponseBerhasil/Soal/ResponseTestcase";

class RequestAmbilInformasiSoalPrivate {

    public execute(idSoal: string, callback : (hasil : any) => void) : void {
        fetch(`http://127.0.0.1:8000/api/soal/informasi/private?id_soal=${idSoal}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {
                callback(new BerhasilAmbilInformasiSoalPrivate(
                    dataDariServer.id_soal,
                    dataDariServer.judul,
                    dataDariServer.soal,
                    {
                        waktu_per_testcase: dataDariServer.waktu_per_testcase, 
                        waktu_total: dataDariServer.waktu_total, 
                        memori: dataDariServer.memori
                    } as ResponseBatasanSoal,
                    dataDariServer.jumlah_submit,
                    dataDariServer.jumlah_berhasil,
                    dataDariServer.status,
                    dataDariServer.id_ruangan_diskusi,
                    dataDariServer.id_pembuat,
                    dataDariServer.nama_pembuat,
                    dataDariServer.testcase as ResponseTestcase[]
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

export default RequestAmbilInformasiSoalPrivate