import IDSoal from "../../Data/IDSoal"
import Testcase from "../../Data/Testcase"

interface InterfaceAmbilSemuaTestcase {

    ambilSemuaTestcase(idSoal : IDSoal, callback : (hasil : any) => void) : void

}

export default InterfaceAmbilSemuaTestcase