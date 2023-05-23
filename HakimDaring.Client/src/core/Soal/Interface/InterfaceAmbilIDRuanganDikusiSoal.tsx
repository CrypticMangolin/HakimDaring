import IDSoal from "../../Data/IDSoal";

interface InterfaceAmbilIDRuanganDikusiSoal {

    ambilIDRuangan(idSoal : IDSoal, callback : (hasil : any) => void) : void
}

export default InterfaceAmbilIDRuanganDikusiSoal