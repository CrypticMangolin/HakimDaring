class KesalahanInputData  {
    private pesan : string

    constructor(pesan : string) {
        this.pesan = pesan
    }

    public ambilPesanError() : string {
        return this.pesan
    }
}

export default KesalahanInputData