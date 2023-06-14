import IDSoal from "../../Data/IDSoal"

interface InterfaceAmbilDaftarPengerjaan {

    ambil(idSoal : IDSoal, callback : (hasil : any) => void) : void
}

export default InterfaceAmbilDaftarPengerjaan