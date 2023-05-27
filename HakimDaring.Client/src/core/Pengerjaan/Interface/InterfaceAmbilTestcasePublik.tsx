import IDSoal from "../../Data/IDSoal"

interface InterfaceAmbilTestcasePublik {

    ambilTestcase(idSoal : IDSoal, callback : (hasil : any) => void) : void
}

export default InterfaceAmbilTestcasePublik