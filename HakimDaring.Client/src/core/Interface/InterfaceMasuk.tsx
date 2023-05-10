import AkunLogin from "../Data/AkunLogin"

interface InterfaceMasuk {

    masuk(dataAkun : AkunLogin, callback : (hasil : any) => void) : void
}

export default InterfaceMasuk