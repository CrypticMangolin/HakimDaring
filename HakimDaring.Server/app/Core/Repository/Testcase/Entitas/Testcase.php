<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Testcase\Entitas;

use App\Core\Repository\Soal\Entitas\IDSoal;

class Testcase {
    
    /**
     * Untuk menyimpan data testcase
     */
    public function __construct(
        private IDTestcase $idTestcase,
        private IDSoal $idSoal,
        private SoalTestcase $soalTestcase,
        private JawabanTestcase $jawabanTestcase,
        private UrutanTestcase $urutanTestcase,
        private PublisitasTestcase $publisitasTestcase
    )
    {
        
    }

    /**
     * Untuk mendapatkan id testcase 
     * 
     * @return IDTestcase id testcase
     */
    public function ambilIDTestcase() : IDTestcase {
        return $this->idTestcase;
    }

    public function ambilIDSoal() : IDSoal {
        return $this->idSoal;
    }

    /**
     * Untuk mengambil jawaban testcase
     * 
     * @return JawabanTestcase jawaban testcase
     */
    public function ambilJawabanTestcase() : JawabanTestcase {
        return $this->jawabanTestcase;
    }

    /**
     * Untuk mengambil soal testcase
     * 
     * @return SoalTestcase soal testcase
     */
    public function ambilSoalTestcase() : SoalTestcase {
        return $this->soalTestcase;
    }

    public function ambilUrutanTestcase() : UrutanTestcase {
        return $this->urutanTestcase;
    }

    public function ambilPublisitasTestcase() : PublisitasTestcase {
        return $this->publisitasTestcase;
    }
}

?>