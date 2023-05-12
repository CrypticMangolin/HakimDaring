class Testcase {
    public testcase : string
    public jawaban : string
    public urutan : number
    public publik : boolean

    constructor(testcase : string, jawaban : string, urutan : number, publik : boolean) {
        this.testcase = testcase
        this.jawaban = jawaban
        this.urutan = urutan
        this.publik = publik
    }
}

export default Testcase