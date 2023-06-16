class BerhasilMengambilDaftarComment {

    constructor(
        public id_comment : string,
        public id_penulis : string,
        public nama_penulis : string,
        public isi : string,
        public reply : string|null,
        public tanggal_penulisan : string,
        public status : string,
    ) {

    }
}

export default BerhasilMengambilDaftarComment