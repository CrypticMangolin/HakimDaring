import Comment from "../../Data/Comment"
import IDRuanganComment from "../../Data/IDRuanganComment"
import IDSoal from "../../Data/IDSoal"

interface InterfaceDaftarComment {

    ambilDaftarComment(idRuangan : IDRuanganComment, callback : (hasil : any) => void) : void
}

export default InterfaceDaftarComment