<?php 

declare(strict_types = 1);

namespace App\Application\Query\Testcase;

class TestcaseDTO {

    public function __construct(
        public string $stdin,
        public string $stdout,
        public bool $publik,
        public int $urutan
    )
    {
        
    }
};

?>