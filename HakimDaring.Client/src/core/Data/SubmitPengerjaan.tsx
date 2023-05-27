import IDSoal from "./IDSoal"

class SubmitPengerjaan {
    public idSoal : IDSoal
    public sourceCode : string
    public bahasa : string

    constructor(idSoal : IDSoal, sourceCode : string, bahasa : string) {
        this.idSoal = idSoal
        this.sourceCode = sourceCode
        this.bahasa = bahasa
    }
}

export default SubmitPengerjaan