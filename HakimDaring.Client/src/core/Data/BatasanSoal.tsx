class BatasanSoal {
    
    public batasan_waktu_per_testcase_dalam_sekon : number
    public batasan_waktu_total_semua_testcase_dalam_sekon : number
    public batasan_memori_dalam_kb : number

    constructor(
        batasan_waktu_per_testcase_dalam_sekon : number, 
        batasan_waktu_total_semua_testcase_dalam_sekon : number,
        batasan_memori_dalam_kb : number
    ) {
        
        this.batasan_waktu_per_testcase_dalam_sekon = batasan_waktu_per_testcase_dalam_sekon
        this.batasan_waktu_total_semua_testcase_dalam_sekon = batasan_waktu_total_semua_testcase_dalam_sekon
        this.batasan_memori_dalam_kb = batasan_memori_dalam_kb
    }
}

export default BatasanSoal