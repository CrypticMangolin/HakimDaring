import InterfaceKeluar from "./Interface/InterfaceKeluar";
import BuatHeader from "./PembuatHeader";

class Keluar implements InterfaceKeluar {
    
    keluar(callback : () => void) : void {
        fetch("http://127.0.0.1:8000/api/logout", {
            method: "POST",
            mode: "cors",
            headers : BuatHeader()
        }).then(() => {
            localStorage.removeItem("token")
            callback()
        });
    }
}

export default Keluar