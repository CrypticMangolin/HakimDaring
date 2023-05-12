import IDSoal from "../IDSoal"

class BerhasilBuatSoal {

    private idSoal : IDSoal

    constructor(idSoal : IDSoal) {
        this.idSoal = idSoal
    }

    public ambilIDSoal() : IDSoal {
        return this.idSoal
    }
}

export default BerhasilBuatSoal