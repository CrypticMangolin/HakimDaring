import AkunRegister from "../Data/AkunRegister"

interface InterfaceDaftar {

    daftar(dataAkun : AkunRegister, callback : (hasil : any) => void) : void
}

export default InterfaceDaftar