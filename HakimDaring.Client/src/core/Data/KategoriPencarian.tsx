class KategoriPencarian {
    public judul : string
    public sortby : string
    public sortbyReverse : boolean

    constructor(judul : string, sortby : string, sortbyReverse : boolean) {
        this.judul = judul
        this.sortby = sortby
        this.sortbyReverse = sortbyReverse
    }
}

export default KategoriPencarian