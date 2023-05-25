import InterfaceDaftarBahasa from "./Interface/InterfaceDaftarBahasa";

import 'ace-builds/src-noconflict/mode-c_cpp'
import 'ace-builds/src-noconflict/mode-java'
import 'ace-builds/src-noconflict/mode-csharp'
import 'ace-builds/src-noconflict/mode-python'
import 'ace-builds/src-noconflict/mode-assembly_x86'
import 'ace-builds/src-noconflict/mode-golang'
import 'ace-builds/src-noconflict/mode-rust'
import 'ace-builds/src-noconflict/mode-kotlin'
import 'ace-builds/src-noconflict/mode-swift'
import 'ace-builds/src-noconflict/mode-javascript'
import 'ace-builds/src-noconflict/mode-typescript'
import 'ace-builds/src-noconflict/mode-php'
import ModeBahasa from "../Data/BahasaPemrograman";
import BahasaPemrograman from "../Data/BahasaPemrograman";

class DaftarBahasa implements InterfaceDaftarBahasa {

    ambilBahasa(): ModeBahasa[] {
        return [
            new BahasaPemrograman("C", "c_cpp"),
            new BahasaPemrograman("C++", "c_cpp"),
            new BahasaPemrograman("Java", "java"),
            new BahasaPemrograman("C#", "csharp"),
            new BahasaPemrograman("Python3",  "python"),
            new BahasaPemrograman("Assembly", "assembly_x86"),
            new BahasaPemrograman("Golang", "golang"),
            new BahasaPemrograman("Rust", "rust"),
            new BahasaPemrograman("Kotlin", "kotlin"),
            new BahasaPemrograman("Swift", "swift"),
            new BahasaPemrograman("JavaScript", "javascript"),
            new BahasaPemrograman("TypeScript", "typescript"),
            new BahasaPemrograman("PHP", "php")
        ]
    }
}

export default DaftarBahasa