import ResponseSoalPencarian from "./ResponseSoalPencarian";

class BerhasilMencari {

    constructor(
        public halaman : number,
        public total_halaman : number,
        public hasil_pencarian : ResponseSoalPencarian[]
    ) {

    }
}

export default BerhasilMencari