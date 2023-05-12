interface ModelSoal {
    id : number|null
    judul : string
    soal : string
    batasan_waktu_per_testcase_dalam_sekon : number
    batasan_waktu_semua_testcase_dalam_sekon : number
    batasan_memori_dalam_kb : number
}

export default ModelSoal