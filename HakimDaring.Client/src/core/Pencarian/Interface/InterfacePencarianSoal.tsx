import KategoriPencarian from "../../Data/KategoriPencarian"

interface InterfacePencarianSoal {

    cariSoal(kategoriPencarian : KategoriPencarian, halaman : number, callback : (hasil : any) => void) : void
}

export default InterfacePencarianSoal