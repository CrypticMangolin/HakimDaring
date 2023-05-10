<?php 

declare(strict_types = 1);

class Pencarian {
    private ?string $kataKunciJudul;

    public function __construct(?string $kataKunciJudul)
    {
        $this->kataKunciJudul = $kataKunciJudul;
    }

    public function ambilKataKunciJudul() : ?string {
        return $this->kataKunciJudul;
    }
}

?>