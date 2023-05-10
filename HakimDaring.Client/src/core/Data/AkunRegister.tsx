class AkunRegister {

    private nama : string
    private email : string
    private password : string
    private ulangi_password : string

    constructor(nama : string, email : string, password : string, ulangi_password : string) {
        this.nama = nama
        this.email = email
        this.password = password
        this.ulangi_password = ulangi_password
    }
}

export default AkunRegister