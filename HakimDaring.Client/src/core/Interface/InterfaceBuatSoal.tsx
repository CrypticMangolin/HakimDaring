import SoalBaru from "../Data/SoalBaru"

interface InterfaceBuatSoal {

    buatSoal(dataSoal : SoalBaru, callback : (hasil : any) => void) : void
}

export default InterfaceBuatSoal