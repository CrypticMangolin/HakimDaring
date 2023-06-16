import ResponseBatasanSoal from "./ResponseBatasanSoal"
import ResponseTestcase from "./ResponseTestcase"

class BerhasilAmbilInformasiSoalPrivate {

    constructor(
        public id_soal : string,
        public judul : string,
        public isi_soal : string,
        public batasan : ResponseBatasanSoal,
        public jumlah_submit : number,
        public jumlah_berhasil : number,
        public status : string,
        public id_ruangan_diskusi : string,
        public id_pembuat : string,
        public nama_pembuat : string,
        public daftar_testcase : ResponseTestcase[]
    ) {

    }
}

export default BerhasilAmbilInformasiSoalPrivate