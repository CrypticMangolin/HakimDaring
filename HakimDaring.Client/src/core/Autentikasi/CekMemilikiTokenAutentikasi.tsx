class CekMemilikiTokenAutentikasi {
    public cekApakahMemilikiTokenAutentikasi() : boolean {
        return localStorage.getItem("token") != null
    }
}

export default CekMemilikiTokenAutentikasi