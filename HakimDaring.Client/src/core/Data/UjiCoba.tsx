import IDSoal from "./IDSoal"

class UjiCoba {
    public idSoal : IDSoal
    public sourceCode : string
    public bahasa : string
    public input : string[]

    constructor(idSoal : IDSoal, sourceCode : string, bahasa : string, input : string[]) {
        this.idSoal = idSoal
        this.sourceCode = sourceCode
        this.bahasa = bahasa
        this.input = input
    }
}

export default UjiCoba