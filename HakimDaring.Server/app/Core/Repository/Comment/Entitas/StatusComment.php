<?php 

declare(strict_types = 1);

namespace App\Core\Repository\Comment\Entitas;

use InvalidArgumentException;

class StatusComment {

    const PUBLIK = "publik";
    const SUSPENDED = "suspended";
    const DELETED = "deleted";

    private $status;

    public function __construct(
        string $status,
        private int $jumlahReport = 0,
    )
    {
        if ($status != self::PUBLIK && $status != self::SUSPENDED && $status != self::DELETED) {
            throw new InvalidArgumentException("status salah");
        }

        $this->status = $status;
    }

    public function ambilStatus() : string {
        return $this->status;
    }

    public function ambilJumlahReport() : int {
        return $this->jumlahReport;
    }

    public function resetReport() : void {
        if ($this->status != self::DELETED) {
            $this->jumlahReport = 0;
            $this->status = self::PUBLIK;
        }
    }

    public function suspend() : void {
        if ($this->status == self::PUBLIK) {
            $this->status = self::SUSPENDED;
        }
    }

    public function delete() : void {
        $this->status = self::DELETED;
    }
}

?>