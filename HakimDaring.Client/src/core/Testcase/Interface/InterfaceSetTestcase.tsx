import BatasanSoal from "../../Data/BatasanSoal"
import IDSoal from "../../Data/IDSoal"
import Testcase from "../../Data/Testcase"

interface InterfaceSetTestcase {

    setTestcase(idSoal : IDSoal, batasanBaru : BatasanSoal, daftarTestcase : Testcase[], callback : (hasil : any) => void) : void

}

export default InterfaceSetTestcase