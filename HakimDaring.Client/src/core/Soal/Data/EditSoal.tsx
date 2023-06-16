import BatasanSoal from "./BatasanSoal"
import Testcase from "./Testcase"

interface EditSoal {
    id_soal : string
    judul : string
    soal : string
    batasan : BatasanSoal
    daftar_testcase : Testcase[]
}

export default EditSoal