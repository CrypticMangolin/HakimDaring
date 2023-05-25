class BerhasilUjiCobaProgram {
    public stdout : string
    public waktu : number
    public memori : number
    public status: string

    constructor(stdout : string, waktu : number, memori : number, status: string) {
        this.stdout = stdout
        this.waktu = waktu
        this.memori = memori
        this.status = status
    }
}

export default BerhasilUjiCobaProgram