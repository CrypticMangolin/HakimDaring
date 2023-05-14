import IDSoal from "./IDSoal";
import Soal from "./Soal";

class SoalUbah {
    public idSoal : IDSoal
    public soal : Soal

    constructor(idSoal : IDSoal, soal : Soal) {
        this.idSoal = idSoal
        this.soal = soal
    }
}

export default SoalUbah