import IDRuanganComment from "../../Data/IDRuanganComment"

interface InterfaceDaftarComment {

    ambilDaftarComment(idRuangan : IDRuanganComment, callback : (hasil : any) => void) : void
}

export default InterfaceDaftarComment