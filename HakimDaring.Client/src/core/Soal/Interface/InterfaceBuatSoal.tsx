import BatasanSoal from "../../Data/BatasanSoal"
import SoalBaru from "../../Data/Soal"
import Testcase from "../../Data/Testcase"

interface InterfaceBuatSoal {

    buatSoal(dataSoal : SoalBaru, batasanBaru : BatasanSoal, daftarTestcase: Testcase[], callback : (hasil : any) => void) : void
}

export default InterfaceBuatSoal