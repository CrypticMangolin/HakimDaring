import IDSoal from "../../Data/IDSoal";

interface InterfaceAmbilInformasiSoal {

    ambilInformasiSoal(idSoal : IDSoal, callback : (hasil : any) => void) : void
}

export default InterfaceAmbilInformasiSoal