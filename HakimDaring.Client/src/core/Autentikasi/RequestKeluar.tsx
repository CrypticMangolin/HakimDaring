import BuatHeader from "../PembuatHeader";

class RequestKeluar {
    
    public execute(callback : () => void) : void {
        fetch("http://127.0.0.1:8000/api/autentikasi/logout", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader()
        }).then(() => {
            localStorage.removeItem("token")
            localStorage.removeItem("nama")
            localStorage.removeItem("id")
            callback()
        });
    }
}

export default RequestKeluar