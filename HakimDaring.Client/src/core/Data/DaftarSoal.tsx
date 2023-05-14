import IDSoal from "./IDSoal"

class DaftarSoal {
    public idSoal : IDSoal
    public judul : string
    public jumlahSubmit : number
    public berhasilSubmit : number
    public persentaseBerhasil : number

    constructor(idSoal : IDSoal, judul : string, jumlahSubmit : number, berhasilSubmit : number, persentaseBerhasil : number) {
        this.idSoal = idSoal
        this.judul = judul
        this.jumlahSubmit = jumlahSubmit
        this.berhasilSubmit = berhasilSubmit
        this.persentaseBerhasil = persentaseBerhasil
    }
}

export default DaftarSoal