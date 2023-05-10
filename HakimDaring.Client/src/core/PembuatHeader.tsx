const BuatHeader = () => {
    let header : any = {
        "Access-Control-Allow-Origin" : "http://127.0.0.1:8000",
        "Content-Type": "application/json"
    }

    if (localStorage.getItem('token') != null) {
        header = {
            ...header,
            "Authorization": `Bearer ${localStorage.getItem('token')}`
        }
    }

    return header
}

export default BuatHeader