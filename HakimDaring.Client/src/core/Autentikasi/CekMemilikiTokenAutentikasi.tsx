import InterfaceCekMemilikiTokenAutentikasi from "./Interface/InterfaceCekMemilikiTokenAutentikasi";

class CekMemilikiTokenAutentikasi implements InterfaceCekMemilikiTokenAutentikasi {
    public cekApakahMemilikiTokenAutentikasi() : boolean {
        return localStorage.getItem("token") != null
    }
}

export default CekMemilikiTokenAutentikasi