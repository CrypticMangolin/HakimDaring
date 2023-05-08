<?php

declare(strict_types = 1);

namespace App\Core\Soal;

use App\Core\Repository\Testcase;

interface InterfacePengecekTestcaseBaruBerbeda {

    /**
     * Untuk membandingkan testcase yang baru dengan testcase yang lama.
     * Perbedaan bila ada satu data testcase yang isinya berbeda atau 
     * tidak ada pada testcase baru namun terdapat pada testcase lama.
     * 
     * @param Testcase[] $testcaseBaru testcase yang baru
     * @param Testcase[] $testcaseLama testcase yang lama
     * 
     * @return bool bernilai True bila kedua testcase berbeda
     */
    public function cekApakahBerbeda(array $testcaseBaru, array $testcaseLama) : bool;
}

?>