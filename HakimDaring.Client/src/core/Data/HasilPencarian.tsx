import DaftarSoal from "./DaftarSoal"

class HasilPencarian {

    public halaman : number
    public totalHalaman : number
    public daftarSoal : DaftarSoal[]

    constructor(halaman : number, totalHalaman : number, daftarSoal : DaftarSoal[]) {
        this.halaman = halaman
        this.totalHalaman = totalHalaman
        this.daftarSoal = daftarSoal
    }

}

export default HasilPencarian