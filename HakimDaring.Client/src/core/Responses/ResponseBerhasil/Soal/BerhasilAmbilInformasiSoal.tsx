import ResponseBatasanSoal from "./ResponseBatasanSoal"

class BerhasilAmbilInformasiSoal {

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
        public nama_pembuat : string
    ) {

    }
}

export default BerhasilAmbilInformasiSoal