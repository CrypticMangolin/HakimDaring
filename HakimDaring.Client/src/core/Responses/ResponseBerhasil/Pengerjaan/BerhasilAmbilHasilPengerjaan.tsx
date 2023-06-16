import ResponseHasilPengerjaanTestcase from "./ResponseHasilPengerjaanTestcase";

class BerhasilAmbilHasilPengerjaan {

    constructor(
        public id_pengerjaan : string,
        public id_user : string,
        public nama_user : string,
        public id_soal : string,
        public judul_soal : string,
        public source_code : string|null,
        public bahasa : string,
        public hasil : string,
        public total_waktu : number,
        public total_memori : number,
        public tanggal_submit : string,
        public outdated : boolean,
        public hasil_testcase : ResponseHasilPengerjaanTestcase[]
    ) {

    }
}

export default BerhasilAmbilHasilPengerjaan