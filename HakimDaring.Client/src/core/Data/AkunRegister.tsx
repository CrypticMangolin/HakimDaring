class AkunRegister {

    public nama : string
    public email : string
    public password : string
    public ulangi_password : string

    constructor(nama : string, email : string, password : string, ulangi_password : string) {
        this.nama = nama
        this.email = email
        this.password = password
        this.ulangi_password = ulangi_password
    }
}

export default AkunRegister