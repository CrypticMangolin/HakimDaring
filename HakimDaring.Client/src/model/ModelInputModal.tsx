import ModelTestcase from "./ModelTestcase"

interface ModelInputModal<T> {

    testcase : ModelTestcase|null
    namaAttribute : string
    nilai : T
}

export default ModelInputModal