class TidakMemilikiHak {
    private pesan : string

    constructor(pesan : string = "tidak memiliki hak") {
        this.pesan = pesan
    }

    public ambilPesanError() : string {
        return this.pesan
    }
}

export default TidakMemilikiHak