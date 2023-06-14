import IDPengerjaan from "./IDPengerjaan"

class HasilRingkasanPengerjaan {

    public idPengerjaan : IDPengerjaan
    public bahasa : string
    public hasil : string
    public tanggalSubmit : Date
    public totalWaktu : number
    public totalMemori : number
    public status : string

    constructor(idPengerjaan : IDPengerjaan, bahasa : string, hasil : string, tanggalSubmit : Date, totalWaktu : number, totalMemori : number, status : string) {
        this.idPengerjaan = idPengerjaan
        this.bahasa = bahasa
        this.hasil = hasil
        this.tanggalSubmit = tanggalSubmit
        this.totalWaktu = totalWaktu
        this.totalMemori = totalMemori
        this.status = status
    }
} 

export default HasilRingkasanPengerjaan