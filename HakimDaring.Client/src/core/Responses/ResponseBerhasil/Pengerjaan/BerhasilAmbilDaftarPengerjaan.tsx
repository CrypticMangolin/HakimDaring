class BerhasilAmbilDaftarPengerjaan {

    constructor(
        public id_pengerjaan : string,
        public id_soal : string,
        public judul_soal : string,
        public bahasa : string,
        public hasil : string,
        public total_waktu : number,
        public total_memori : number,
        public tanggal_submit : string,
        public outdated : boolean,
    ) {

    }
}

export default BerhasilAmbilDaftarPengerjaan