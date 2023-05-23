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
import ModeBahasa from "../Data/ModeBahasa";

class DaftarBahasa implements InterfaceDaftarBahasa {

    ambilBahasa(): ModeBahasa[] {
        return [
            new ModeBahasa("C", "c_cpp"),
            new ModeBahasa("C++", "c_cpp"),
            new ModeBahasa("Java", "java"),
            new ModeBahasa("C#", "csharp"),
            new ModeBahasa("Python",  "python"),
            new ModeBahasa("Assembly", "assembly_x86"),
            new ModeBahasa("Golang", "golang"),
            new ModeBahasa("Rust", "rust"),
            new ModeBahasa("Kotlin", "kotlin"),
            new ModeBahasa("Swift", "swift"),
            new ModeBahasa("JavaScript", "javascript"),
            new ModeBahasa("TypeScript", "typescript"),
            new ModeBahasa("PHP", "php")
        ]
    }
}

export default DaftarBahasa