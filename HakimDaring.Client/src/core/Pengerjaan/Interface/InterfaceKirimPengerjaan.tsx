import SubmitPengerjaan from "../../Data/SubmitPengerjaan"

interface InterfaceKirimPengerjaan {

    kirimPengerjaanProgram(pengerjaan : SubmitPengerjaan, callback : (hasil : any) => void) : void
}

export default InterfaceKirimPengerjaan