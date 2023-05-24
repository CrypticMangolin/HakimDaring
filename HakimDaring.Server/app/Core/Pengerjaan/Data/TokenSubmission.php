<?php 

declare(strict_types = 1);

namespace App\Core\Pengerjaan\Data;

class TokenSubmission {
    public function __construct(
        private string $token
    ) {}

    public function ambilToken() : string {
        return $this->token;
    }
}

?>