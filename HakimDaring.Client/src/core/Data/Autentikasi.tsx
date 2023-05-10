
class Autentikasi {
    private token : string

    constructor(token : string) {
        this.token = token
    }

    public ambilToken() : string {
        return this.token
    }
}

export default Autentikasi