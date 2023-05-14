import SoalBaru from "../../Data/Soal"

interface InterfaceBuatSoal {

    buatSoal(dataSoal : SoalBaru, callback : (hasil : any) => void) : void
}

export default InterfaceBuatSoal