import SoalUbah from "../../Data/SoalUbah"

interface InterfaceUbahSoal {

    ubahSoal(soal : SoalUbah, callback : (hasil : any) => void) : void
}

export default InterfaceUbahSoal