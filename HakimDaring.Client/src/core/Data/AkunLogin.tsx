class AkunLogin {    
    private email : string
    private password : string

    constructor(email : string, password : string) {
        this.email = email
        this.password = password
    }

    public ambilEmail() : string {
        return this.email
    }

    public ambilPassword() : string {
        return this.password
    }
}

export default AkunLogin