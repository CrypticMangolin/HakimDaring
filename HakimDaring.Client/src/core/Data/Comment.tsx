import IDComment from "./IDComment"
import IDUser from "./IDUser"

class Comment {

    public id : IDComment
    public namaPenulis : string
    public pesan : string
    public tanggalPenulisan : Date
    public reply : IDUser|null

    constructor(id : IDComment, namaPenulis : string, pesan : string, tanggalPenulisan : Date, reply : IDUser|null) {
        this.id = id
        this.namaPenulis = namaPenulis
        this.pesan = pesan
        this.tanggalPenulisan = tanggalPenulisan
        this.reply = reply
    }
}

export default Comment