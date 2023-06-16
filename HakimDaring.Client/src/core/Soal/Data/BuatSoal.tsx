import BatasanSoal from "./BatasanSoal"
import Testcase from "./Testcase"

interface BuatSoal {
    judul : string
    soal : string
    batasan : BatasanSoal
    daftar_testcase : Testcase[]
}

export default BuatSoal