<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Pengerjaan\Entitas;

class HasilSubmission {
    public function __construct(
        private TokenSubmission $token,
        private string $stdout,
        private float $time,
        private int $memori,
        private ?string $error,
        private string $status
    ) {}

    public function ambilToken() : TokenSubmission {
        return $this->token;
    }

    public function ambilHasilKeluaran() : string {
        return $this->stdout;
    }

    public function ambilWaktu() : float {
        return $this->time;
    }

    public function ambilMemori() : int {
        return $this->memori;
    }

    public function ambilError() : ?string {
        return $this->error;
    }

    public function ambilStatus() : string {
        return $this->status;
    }
}

?>