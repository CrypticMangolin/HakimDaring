import DaftarSoal from "../Data/DaftarSoal";
import HasilPencarian from "../Data/HasilPencarian";
import IDSoal from "../Data/IDSoal";
import KategoriPencarian from "../Data/KategoriPencarian";
import KesalahanInputData from "../Data/ResponseGagal/KesalahanInputData";
import KesalahanInternalServer from "../Data/ResponseGagal/KesalahanInternalServer";
import BuatHeader from "../PembuatHeader";
import InterfacePencarianSoal from "./Interface/InterfacePencarianSoal";

class PencarianSoal implements InterfacePencarianSoal {
    
    cariSoal(kategoriPencarian: KategoriPencarian, halaman : number, callback: (hasil: any) => void): void {

        fetch(`http://127.0.0.1:8000/api/cari-soal?halaman=${halaman}&judul=${kategoriPencarian.judul}&sort_by=${kategoriPencarian.sortby}&sort_reverse=${kategoriPencarian.sortbyReverse}`, {
            method: "GET",
            mode: "cors",
            headers : BuatHeader()
        }).then(async (response) => {
            let dataDariServer = await response.json()

            if (response.ok) {

                let daftarSoal : DaftarSoal[] = []
                dataDariServer.hasil_pencarian.forEach((element: { id: any; judul: string; jumlah_submit: number; jumlah_berhasil: number; persentase_berhasil: number; }) => {
                    daftarSoal.push(new DaftarSoal(
                        new IDSoal(element.id),
                        element.judul,
                        element.jumlah_submit,
                        element.jumlah_berhasil,
                        element.persentase_berhasil
                    ))
                })

                let hasilPencarian: HasilPencarian = new HasilPencarian(dataDariServer.halaman, dataDariServer.total_halaman, daftarSoal)

                callback(hasilPencarian)
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

export default PencarianSoal