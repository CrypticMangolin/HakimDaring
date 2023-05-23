import IDComment from "../../Data/IDComment"
import IDRuanganComment from "../../Data/IDRuanganComment"

interface InterfaceKirimComment {

    kirimComment(idRuangan : IDRuanganComment, pesan : string, reply : IDComment|null, callback : (hasil : any) => void) : void
}

export default InterfaceKirimComment