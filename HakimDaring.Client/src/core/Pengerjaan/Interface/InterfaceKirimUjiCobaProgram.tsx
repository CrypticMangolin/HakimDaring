import UjiCoba from "../../Data/UjiCoba"

interface InterfaceKirimUjiCobaProgram {

    kirimUjiCoba(ujiCoba : UjiCoba, callback : (hasil : any) => void) : void
}

export default InterfaceKirimUjiCobaProgram