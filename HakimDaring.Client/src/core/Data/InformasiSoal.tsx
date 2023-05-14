import IDSoal from './IDSoal'

class InformasiSoal {
    public idSoal : IDSoal
    public judul : string 
    public soal  : string
    public versi : number
    public status : string
    public batasanWaktuPerTestcase : number
    public batasanWaktuTotal : number
    public batasanMemoriDalamKB : number
    public totalSubmit : number
    public totalBerhasil : number

    constructor( idSoal : IDSoal,
        judul : string,
        soal  : string,
        versi : number,
        status : string,
        batasanWaktuPerTestcase : number,
        batasanWaktuTotal : number,
        batasanMemoriDalamKB : number,
        totalSubmit : number,
        totalBerhasil : number,
    ) {
        this.idSoal = idSoal
        this.judul = judul
        this.soal = soal
        this.versi = versi
        this.status = status
        this.batasanWaktuPerTestcase = batasanWaktuPerTestcase
        this.batasanWaktuTotal = batasanWaktuTotal
        this.batasanMemoriDalamKB = batasanMemoriDalamKB
        this.totalSubmit = totalSubmit
        this.totalBerhasil = totalBerhasil
    }
}

export default InformasiSoal